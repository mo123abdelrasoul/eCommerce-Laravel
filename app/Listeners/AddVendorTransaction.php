<?php

namespace App\Listeners;

use App\Events\OrderUpdated;
use App\Models\VendorWalletTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddVendorTransaction
{
    public function __construct() {}

    public function handle(OrderUpdated $event): void
    {
        $order = $event->order;
        $vendor = $order->vendor;
        $oldStatus = $event->oldStatus;
        $newStatus = $order->status;
        if ($oldStatus === $newStatus) {
            return;
        }
        if ($order->payment_status !== 'paid') {
            return;
        }
        switch ($newStatus) {
            case 'completed':
                $this->addToVendorTransaction($vendor, $order);
                break;
            case 'cancelled':
                if ($oldStatus === 'completed') {
                    $this->deductFromVendorTransaction($vendor, $order);
                }
                break;
        }
    }
    private function addToVendorTransaction($vendor, $order)
    {
        VendorWalletTransaction::create([
            'vendor_id' => $vendor->id,
            'order_id' => $order->id,
            'type' => 'credit',
            'amount' => $order->total_amount,
            'description' => 'Order: ' . $order->order_number . ' completed payment added to wallet.',
        ]);
    }
    private function deductFromVendorTransaction($vendor, $order)
    {
        VendorWalletTransaction::create([
            'vendor_id' => $vendor->id,
            'order_id' => $order->id,
            'type' => 'debit',
            'amount' => -$order->total_amount,
            'description' => 'Order: ' . $order->order_number . ' cancelled, amount deducted from wallet.',
        ]);
    }
}
