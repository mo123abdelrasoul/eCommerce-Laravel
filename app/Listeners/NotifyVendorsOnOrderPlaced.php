<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\Vendor;
use App\Notifications\VendorOrderPlacedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyVendorsOnOrderPlaced
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $orders = collect($event->orders);
        $vendorIds = Order::whereIn('id', $orders->pluck('id'))->pluck('vendor_id')->unique();
        $vendors = Vendor::whereIn('id', $vendorIds)->get();
        foreach ($vendors as $vendor) {
            foreach ($orders as $order) {
                if ($order->vendor_id == $vendor->id) {
                    $vendor->notify(new VendorOrderPlacedNotification($order));
                }
            }
        }
    }
}
