<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Interfaces\PaymentGatewayInterface;
use App\Services\PaymobPaymentService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PaymentFactory
{
    public static function make(string $gateway): PaymentGatewayInterface
    {
        return match ($gateway) {
            'card', 'wallet' => app(PaymobPaymentService::class),
            default => throw new \Exception("Unsupported payment gateway: {$gateway}"),
        };
    }
}
