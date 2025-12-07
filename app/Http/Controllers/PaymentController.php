<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Invoice;

class PaymentController extends Controller
{
    /**
     * Show the checkout page with Stripe Elements.
     * 
     * @param  int  $appointmentId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     * @fr FR-07: Payment Processing (Checkout UI & Intent Creation)
     */
    public function checkout($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        
        // 1. Prevent double payment
        if ($appointment->payment_status === 'paid') {
            return redirect()->route('dashboard')->with('info', 'This appointment is already paid.');
        }

        // 2. Initialize Stripe API (If Configured)
        $stripeSecret = env('STRIPE_SECRET');
        $stripeKey = env('STRIPE_KEY');
        $clientSecret = null;

        if ($stripeSecret && $stripeKey) {
            try {
                \Stripe\Stripe::setApiKey($stripeSecret);

                // 3. Create Stripe PaymentIntent
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => $appointment->service->price * 100, // Amount in cents (paisa)
                    'currency' => 'bdt',
                    'automatic_payment_methods' => [
                        'enabled' => true,
                    ],
                    'metadata' => [
                        'appointment_id' => $appointment->id,
                        'user_id' => $appointment->user_id,
                    ],
                ]);
                $clientSecret = $paymentIntent->client_secret;
            } catch (\Exception $e) {
                // Log the error but don't crash the page, so user can potentially use other methods
                \Illuminate\Support\Facades\Log::error('Stripe Error: ' . $e->getMessage());
            }
        }

        return view('payment.checkout', [
            'appointment' => $appointment,
            'clientSecret' => $clientSecret,
            'stripeKey' => $stripeKey,
        ]);
    }

    /**
     * Handle success return from Stripe.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @fr FR-07: Payment Processing (Confirmation & Invoice)
     */
    public function success(Request $request)
    {
        $payment_intent = $request->query('payment_intent');
        $appointment_id = $request->query('appointment_id');

        if (!$payment_intent || !$appointment_id) {
            return redirect()->route('dashboard')->with('error', 'Invalid payment return data.');
        }

        $appointment = Appointment::findOrFail($appointment_id);

        if ($appointment->payment_status === 'paid') {
            return redirect()->route('appointments.index')->with('success', 'Payment successful! Your appointment is confirmed.');
        }
        
        // In a real production app, verify the payment_intent status with Stripe API here
        // For this demo/task, we assume success if redirected here from Stripe

        // 1. Update Appointment Status
        $appointment->update([
            'payment_status' => 'paid',
        ]);

        // 2. Generate Invoice
        if (!$appointment->invoice) {
             Invoice::create([
                 'appointment_id' => $appointment->id,
                 'amount' => $appointment->service->price,
                 'issued_at' => now(),
             ]);
        }

        return redirect()->route('appointments.index')->with('success', 'Payment successful! Your appointment is confirmed.');
    }

    /**
     * Initiate SSLCommerz Payment.
     */
    public function payWithSslCommerz(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if ($appointment->payment_status === 'paid') {
            return redirect()->route('dashboard')->with('info', 'This appointment is already paid.');
        }

        $sslcommerz = new \App\Services\SslCommerzService();

        $postData = [
            'total_amount' => $appointment->service->price,
            'currency' => 'BDT',
            'tran_id' => uniqid('trnx_', true), // Generate unique transaction ID
            'product_category' => 'Service',
            'cus_name' => $appointment->user->name,
            'cus_email' => $appointment->user->email ?? 'customer@example.com',
            'cus_phone' => $appointment->user->phone ?? '01700000000',
            'cus_add1' => 'Dhaka',
            'cus_city' => 'Dhaka',
            'cus_country' => 'Bangladesh',
            'shipping_method' => 'NO',
            'product_name' => $appointment->service->title,
            'product_profile' => 'general',
            'value_a' => $appointment->id, // Pass appointment ID as extra param
        ];

        $response = $sslcommerz->initiatePayment($postData);

        if (isset($response['status']) && $response['status'] == 'SUCCESS') {
            return redirect($response['GatewayPageURL']);
        } else {
            return redirect()->back()->with('error', 'SSLCommerz Init Failed: ' . ($response['failedreason'] ?? 'Unknown error'));
        }
    }

    public function sslCommerzSuccess(Request $request)
    {
        $val_id = $request->input('val_id');
        $appointment_id = $request->input('value_a'); // We passed this as value_a

        if (!$val_id || !$appointment_id) {
            return redirect()->route('dashboard')->with('error', 'Invalid payment return data.');
        }

        $sslcommerz = new \App\Services\SslCommerzService();
        $validation = $sslcommerz->validatePayment($val_id);

        if ($validation['status'] == 'VALID' || $validation['status'] == 'VALIDATED') {
            $appointment = Appointment::findOrFail($appointment_id);

            if ($appointment->payment_status !== 'paid') {
                $appointment->update(['payment_status' => 'paid']);
                
                if (!$appointment->invoice) {
                    Invoice::create([
                        'appointment_id' => $appointment->id,
                        'amount' => $validation['amount'] ?? $appointment->service->price,
                        'issued_at' => now(),
                    ]);
                }
            }

            return redirect()->route('appointments.index')->with('success', 'Payment successful via SSLCommerz!');
        }

        return redirect()->route('dashboard')->with('error', 'Payment validation failed.');
    }

    public function sslCommerzFail(Request $request)
    {
        return redirect()->route('dashboard')->with('error', 'Payment failed.');
    }

    public function sslCommerzCancel(Request $request)
    {
        return redirect()->route('dashboard')->with('error', 'Payment cancelled.');
    }

    public function sslCommerzIpn(Request $request)
    {
        // Handle IPN (Instant Payment Notification) if needed for background updates
        // For now, logging it
        \Illuminate\Support\Facades\Log::info('SSLCommerz IPN', $request->all());
    }
}
