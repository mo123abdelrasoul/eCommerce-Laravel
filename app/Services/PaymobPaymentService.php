<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PaymobPaymentService extends PaymentService implements PaymentGatewayInterface
{
    protected $api_key;
    protected $integrations_id;
    // protected $base_url;
    protected array $header = [];
    protected $auth_token;
    public function __construct()
    {
        $this->base_url = config('services.paymob.base_url');
        $this->api_key = config('services.paymob.api_key');
        $this->header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        // dd($this->base_url, $this->api_key);
        $this->integrations_id = [
            'card' => config('services.paymob.card_integration_id'),
            'wallet' => config('services.paymob.wallet_integration_id'),
        ];
    }

    public function sendPayment($checkoutData)
    {
        $authToken = $this->generateToken();
        $integrationId = $this->getIntegrationId($checkoutData['payment_gateway']);

        // 1- Create Order
        $orderPayload = $this->buildOrderPayload($checkoutData['amount_cents'], $authToken);
        $orderResponse = $this->buildRequest('POST', '/api/ecommerce/orders', $orderPayload);
        $orderId = $orderResponse->getData(true)['id'] ?? $orderResponse->getData(true)['data']['id'] ?? null;
        if (!$orderId) {
            return [
                'success' => false,
                'message' => 'Failed to create Paymob order.',
            ];
        }
        if (!empty($checkoutData['payment_id'])) {
            Payment::where('id', $checkoutData['payment_id'])
                ->update(['reference' => $orderId]);
        }

        // 2- Generate Payment Key
        $paymentKeyPayload = $this->buildPaymentKeyPayload($authToken, $checkoutData, $orderId, $integrationId);
        $paymentKeyResponse = $this->buildRequest('POST', '/api/acceptance/payment_keys', $paymentKeyPayload);
        $paymentKeyData = $paymentKeyResponse->getData(true);
        $paymentKey = $paymentKeyData['token'] ?? $paymentKeyData['data']['token'] ?? null;
        if (!$paymentKey) {
            return [
                'success' => false,
                'message' => 'Failed to generate payment key.',
                'response' => $paymentKeyData
            ];
        }

        // 3- Prepare Payment URL
        $customerIdentifier  = $this->getCustomerIdentifier($checkoutData);
        $paymentUrl = $this->buildPaymentUrl($checkoutData['payment_gateway'], $customerIdentifier, $paymentKey);
        if (!$paymentUrl) {
            return [
                'success' => false,
                'message' => 'Failed to generate payment URL.',
                'payment_url' => null,
            ];
        }
        return [
            'success' => true,
            'redirect_url' => $paymentUrl,
            'payment_id' => $checkoutData['payment_id']
        ];
    }

    public function generateToken()
    {
        $response = $this->buildRequest('POST', '/api/auth/tokens', ['api_key' => $this->api_key]);
        $data = $response->getData(true);
        $this->auth_token = $data['token'] ?? $data['data']['token'] ?? null;
        if (!$this->auth_token) {
            throw new \Exception('Failed to generate Paymob auth token.');
        }
        $this->header['Authorization'] = 'Bearer ' . $this->auth_token;
        return $this->auth_token;
    }

    private function buildOrderPayload($amountCent, $token)
    {
        return [
            'auth_token' => $token,
            'amount_cents' => (int) ($amountCent ?? 0),
            'currency' => 'EGP',
            'delivery_needed' => false,
            'items' => [],
        ];
    }

    private function buildPaymentKeyPayload($authToken, $checkoutData, $orderId, $integrationId)
    {
        return [
            'auth_token' => $authToken,
            'amount_cents' => (int) ($checkoutData['amount_cents'] ?? 1000), // مبلغ صغير للتيست
            'expiration' => 3600,
            'order_id' => $orderId,
            'currency' => 'EGP',
            'integration_id' => $integrationId,
            'billing_data' => [
                'first_name' => explode(' ', $checkoutData['name'])[0] ?? 'NA',
                'last_name' => explode(' ', $checkoutData['name'])[1] ?? 'NA',
                'email' => $checkoutData['email'] ?? 'NA',
                'phone_number' => $checkoutData['phone'],
                'street' => $checkoutData['street_name'] ?? 'NA',
                'building' => 'NA',
                'floor' => 'NA',
                'apartment' => 'NA',
                'city' => 'NA',
                'state' => 'NA',
                'country' => 'EG',
                'postal_code' => $checkoutData['zip_code'] ?? 'NA',
                'shipping_method' => 'NA',
            ],
            'callback' => route('payment.callback', ['lang' => app()->getLocale()]),
            'redirect_url' => route('payment.callback', ['lang' => app()->getLocale()])
        ];
    }

    private function buildPaymentUrl($gateway, $customerIdentifier, $paymentKey)
    {
        if ($gateway == 'card') {
            return "{$this->base_url}/api/acceptance/iframes/{$customerIdentifier}?payment_token={$paymentKey}";
        } elseif ($gateway == 'wallet') {
            $pay = $this->buildRequest('POST', '/api/acceptance/payments/pay', [
                'source' => [
                    'identifier' => $customerIdentifier,
                    'subtype' => 'WALLET'
                ],
                'payment_token' => $paymentKey
            ]);
            $url = $pay->getData(true)['data']['redirect_url'] ?? '';
            return $url ? trim(str_replace(["\r", "\n"], '', $url)) : null;
        }
        return null;
    }

    private function getIntegrationId($gateway)
    {
        switch ($gateway) {
            case 'card':
                return $this->integrations_id['card'];
            case 'wallet':
                return $this->integrations_id['wallet'];
            default:
                return $this->integrations_id['card'];
        }
    }

    private function getCustomerIdentifier($checkoutData)
    {
        if ($checkoutData['payment_gateway'] == 'card') {
            return env('PAYMOB_CARD_IFRAME_ID');
        } elseif ($checkoutData['payment_gateway'] == 'wallet') {
            return $checkoutData['phone'];
        }
        throw new \Exception('Unsupported payment gateway type: ' . $checkoutData['payment_gateway']);
    }

    public function callBack(Request $request)
    {
        $response = $request->all();
        // Storage::put('paymob_response.json', json_encode($request->all()));
        if (isset($response['success']) && $response['success'] === true) {
            return true;
        }
        return false;
    }
}
