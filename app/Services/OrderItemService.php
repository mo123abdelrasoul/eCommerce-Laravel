<?php

namespace App\Services;

use App\Models\Order;

class OrderItemService
{

    public function createItems(Order $order, array $products): void
    {
        foreach ($products as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'product_price' => $item['discountedPrice'],
                'quantity' => $item['quantity'],
                'total_price' => $item['discountedPrice'] * $item['quantity'],
            ]);
        }
    }
}
