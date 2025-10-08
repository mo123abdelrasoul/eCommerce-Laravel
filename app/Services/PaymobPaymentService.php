<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PaymobPaymentService extends PaymentService implements PaymentGatewayInterface
{
    protected $api_key;
    protected $integrations_id;
    public function __construct()
    {
        $this->base_url = env('PAYMOB_BASE_URL');
        $this->api_key = env('PAYMOB_API_KEY');
        $this->header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $this->integrations_id = ['4250566', '4261378'];
    }
    public function generateToken()
    {
        $response = $this->buildRequest('POST', '/api/auth/tokens', ['api_key' => $this->api_key]);
        return $response->getData(true)['data']['token'];
    }
    public function sendPayment(Request $request)
    {
        $this->header['Authorization'] = 'bearer' . $this->generateToken();
        $data = $request->all();
        $data['api_source'] = 'INVOICE';
        $data['integrations'] = $this->integrations_id;
        $response = $this->buildRequest('POST', '/api/ecommerce/orders', $data);
        if ($response->getData(true)['success']) {
            return [
                'success' => true,
                'url' => $response->getData(true)['data']['url']
            ];
        }
        return [
            'success' => false,
            'url' => route('payment.failed')
        ];
    }
    public function callBack(Request $request)
    {
        $response = $request->all();
        Storage::put('paymob_response.json', json_encode($request->all()));
        if (isset($response['success']) && $response['success'] === true) {
            return true;
        }
        return false;
    }
}
