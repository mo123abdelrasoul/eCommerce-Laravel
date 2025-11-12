<?php

namespace App\Services;

use App\Models\PaymentMethod;

class PaymentMethodService
{

    public function getPaymentMethodCode(int $paymentMethodId): string
    {
        $code = PaymentMethod::where('id', $paymentMethodId)->value('code');

        if (!$code) {
            throw new \Exception('Payment method not found.');
        }

        return $code;
    }
}
