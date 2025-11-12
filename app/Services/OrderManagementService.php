<?php

namespace App\Services;

use App\Models\Order;
use App\Events\OrderUpdated;
use Illuminate\Support\Facades\DB;

class OrderManagementService
{

    public function updateOrder(Order $order, array $data): bool
    {
        $totalAmount = $order->total_amount;

        if (isset($data['shipping_cost']) && $order->shipping_cost !== $data['shipping_cost']) {
            $totalAmount = ($order->sub_total + $data['shipping_cost']) - $order->discount_amount;
        }
        $oldStatus = $order->status;
        return DB::transaction(function () use ($order, $data, $totalAmount, $oldStatus) {
            $updated = $order->update([
                'status'          => $data['status'],
                'payment_status'  => $data['payment_status'],
                'shipping_cost'   => $data['shipping_cost'],
                'notes'           => $data['notes'] ?? null,
                'total_amount'    => $totalAmount,
            ]);
            if (! $updated) {
                return false;
            }
            if (in_array($data['status'], ['completed', 'cancelled'])) {
                event(new OrderUpdated($order, $oldStatus));
            }
            return true;
        });
    }
}
