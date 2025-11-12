<?php

namespace App\Services;

use App\Models\Order;

class OrderCreatorService
{

    public function create(array $data): Order
    {
        return Order::create([
            'customer_id' => $data['customer_id'],
            'order_number' => $data['order_number'],
            'status' => $data['status'] ?? 'pending',
            'total_amount' => $data['total_amount'],
            'payment_status' => $data['payment_status'] ?? 'pending',
            'payment_method' => $data['payment_method'],
            'shipping_address' => json_encode($data['shipping_address']),
            'billing_address' => json_encode($data['billing_address']),
            'shipping_cost' => $data['shipping_cost'],
            'total_weight' => $data['total_weight'],
            'discount_amount' => $data['discount_amount'],
            'tax_amount' => $data['tax_amount'] ?? 0,
            'notes' => $data['notes'] ?? null,
            'vendor_id' => $data['vendor_id'],
            'sub_total' => $data['sub_total'],
            'shipping_method_id' => $data['shipping_method_id'],
            'coupon_id' => $data['coupon_id'] ?? null,
        ]);
    }
}
