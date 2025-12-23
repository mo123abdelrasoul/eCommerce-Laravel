<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\PaymentMethod;
use Database\Factories\PaymentFactory;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $base_url;
    protected array $header;


    public function process($totalAmount, $checkoutData)
    {
        $paymentGateway = PaymentMethod::where('id', $checkoutData['payment_method'])->value('code');
        $gateway = $this->getGateway($paymentGateway);
        $checkoutData['amount_cents'] = $totalAmount * 100;
        $checkoutData['payment_gateway'] = $paymentGateway;
        $userId = Auth::id();
        $payment = Payment::create([
            'customer_id'  => $userId,
            'gateway'      => $paymentGateway,
            'amount_cents' => $checkoutData['amount_cents'],
            'currency'     => 'EGP',
            'status'       => 'pending',
        ]);
        $checkoutData['payment_id'] = $payment->id;
        if ($gateway == 'cod') {
            return [
                'success' => true,
                'message' => 'Order created successfully.',
                'payment_id' => $checkoutData['payment_id'],
            ];
        }
        return $gateway->sendPayment($checkoutData);
    }
    private function getGateway($paymentGateway)
    {
        switch ($paymentGateway) {
            case 'cod':
                return 'cod';
            case 'card':
            case 'wallet':
                return PaymentFactory::make($paymentGateway);
        }
    }
    protected function buildRequest($method, $url, $data = null, $type = 'json')
    {
        try {
            $fullUrl = $this->base_url . $url;
            Log::info('Sending request to: ' . $fullUrl, [
                'method' => $method,
                'data' => $data,
            ]);
            $response = Http::withHeaders($this->header)
                ->withoutVerifying() // لازم قبل send()
                ->send($method, $this->base_url . $url, [
                    $type => $data
                ]);


            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'status'  => $response->status(),
                    'data'    => $response->json()
                ], $response->status());
            }
            return response()->json([
                'success' => false,
                'status'  => $response->status(),
                'message' => $response->body()
            ], $response->status());
        } catch (Exception $e) {
            Log::error('Paymob HTTP Exception', [
                'message' => $e->getMessage(),
                'method' => $method,
                'url' => $fullUrl,
                'data' => $data,
            ]);
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
