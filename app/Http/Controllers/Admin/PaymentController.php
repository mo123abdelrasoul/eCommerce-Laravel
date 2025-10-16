<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\PaymentGatewayInterface;
use Database\Factories\PaymentFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function paymentProcess(Request $request)
    {
        $gateway = PaymentFactory::make($request->payment_method);
        return $gateway->sendPayment($request);
    }
    public function callback($lang, Request $request): RedirectResponse
    {
        dd('Paymob Callback Data: ' . json_encode($request->all()));
        // $response = $this->paymentGateway->callBack($request);
        if ($response) {
            return redirect()->route('payment.success');
        }
        return redirect()->route('payment.failed');
    }
    public function success()
    {
        return view('payment-success');
    }
    public function failed()
    {
        return view('payment-failed');
    }
}
