<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\Payment;
use Database\Factories\PaymentFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function paymentProcess(Request $request)
    {
        $gateway = PaymentFactory::make($request->payment_method);
        return $gateway->sendPayment($request);
    }
    public function callback($lang, Request $request)
    {
        $data = $request->query();
        $payment = Payment::where('reference', $data['order'])->first();

        if (!$payment) {
            return redirect()->route('payment.failed', ['lang' => app()->getLocale()])
                ->with('message', 'Invalid payment reference.');
        }

        if ($data['success'] === 'false') {
            return redirect()->route('payment.failed', ['lang' => app()->getLocale()])
                ->with('message', 'Payment failed.');
        }

        $payment->update([
            'transaction_id' => $data['id'],
            'status' => 'paid',
        ]);

        return redirect()->route('payment.success', ['lang' => app()->getLocale()])
            ->with('message', 'Payment succeeded!');
    }
    public function success($lang, Payment $payment)
    {
        foreach ($payment->orders as $order) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);
            if (!empty($order->coupon_id)) {
                DB::table('coupon_users')->updateOrInsert(
                    [
                        'coupon_id' => $order->coupon_id,
                        'user_id'   => $order->customer_id,
                    ],
                    [
                        'times_used' => DB::raw('times_used + 1'),
                    ]
                );
            }
        }
        return view('user.payment.payment-success');
    }
    public function failed($lang, Payment $payment)
    {
        foreach ($payment->orders as $order) {
            $order->update([
                'payment_status' => 'failed',
                'status' => 'cancelled',
            ]);
        }
        return view('user.payment.payment-failed');
    }
}
