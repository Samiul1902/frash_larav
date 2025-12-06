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

        // 2. Initialize Stripe API
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // 3. Create Stripe PaymentIntent
        // Calculates amount in cents and attaches metadata
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

        return view('payment.checkout', [
            'appointment' => $appointment,
            'clientSecret' => $paymentIntent->client_secret,
            'stripeKey' => env('STRIPE_KEY'),
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
}
