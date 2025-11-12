<?php

namespace App\Services;

use App\Models\Order;

class OrderNumberGeneratorService
{
    public function generate(): string
    {
        do {
            $number = 'ORD-' . mt_rand(1000, 9999);
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
