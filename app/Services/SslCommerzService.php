<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SslCommerzService
{
    protected $storeId;
    protected $storePassword;
    protected $sandbox;
    protected $baseUrl;

    public function __construct()
    {
        $this->storeId = config('services.sslcommerz.store_id');
        $this->storePassword = config('services.sslcommerz.store_password');
        $this->sandbox = config('services.sslcommerz.sandbox', true);

        $this->baseUrl = $this->sandbox
            ? 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php'
            : 'https://securepay.sslcommerz.com/gwprocess/v4/api.php';
    }

    public function initiatePayment(array $data)
    {
        $postData = array_merge([
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'currency' => 'BDT',
            'success_url' => route('payment.sslcommerz.success'),
            'fail_url' => route('payment.sslcommerz.fail'),
            'cancel_url' => route('payment.sslcommerz.cancel'),
            'ipn_url' => route('payment.sslcommerz.ipn'),
        ], $data);

        try {
            $response = Http::asForm()->post($this->baseUrl, $postData);
            
            if ($response->successful()) {
                $result = $response->json();
                
                if (isset($result['status']) && $result['status'] === 'FAILED') {
                     return ['status' => 'error', 'message' => $result['failedreason'] ?? 'Unknown error'];
                }
                
                return $result;
            }

            return ['status' => 'error', 'message' => 'Connection to Gateway failed'];
        } catch (\Exception $e) {
            Log::error('SSLCommerz Init Error: ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function validatePayment($val_id)
    {
        $validationUrl = $this->sandbox
            ? 'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php'
            : 'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php';

        $response = Http::get($validationUrl, [
            'val_id' => $val_id,
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'format' => 'json'
        ]);

        return $response->json();
    }
}
