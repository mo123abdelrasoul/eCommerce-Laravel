<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

use function Termwind\parse;

class OrderService
{
    public function handle($cart, $cartTotal, $checkoutData)
    {
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $unique = $this->uniqueNumber();
        $user = Auth::guard('web')->user();
        $payment_method = PaymentMethod::select('name')->where('id', $checkoutData['payment_method'])->first();
        if (!$payment_method) {
            return "wrong";
        }
        $totalAmount = ($cartTotal) + (session('shipping_rate', 0)) - (session('discount_value', 0));
        $shippingAddress = [
            "city" => $checkoutData['city'],
            "street_number" => $checkoutData['street_number'],
            "street_name" => $checkoutData['street_name'],
            "zip" => $checkoutData['zip_code']
        ];
        $vendorIds = $products->pluck('vendor_id')->unique()->values()->all();
        foreach ($vendorIds as $vendorId) {
            $totalWeight = 0;
            $vendorCart = [];
            foreach ($products as $product) {
                if ($product['vendor_id'] === $vendorId) {
                    $totalWeight += $product->weight * $cart[$product->id];
                    $vendorCart[$product->id] = $cart[$product->id];
                }
            }
            $vendorProductIds = array_keys($vendorCart);
            $vendorProducts = Product::whereIn('id', $vendorProductIds)->get()->keyBy('id');
            $vendorCartTotal = 0;
            foreach ($vendorProducts as $product) {
                $vendorCartTotal += $product->price * $vendorCart[$product->id];
            }
            $shipping_calculate = (new ShippingService())->calculate($vendorCart, $checkoutData, $vendorCartTotal);
            dd($shipping_calculate['rate']);
            Order::create([
                'customer_id' => $user->id,
                'status' => 'pending',
                'total_amount' => number_format($totalAmount, 2, '.', ''),
                'payment_status' => 'pending',
                'payment_method' => $payment_method->name,
                'shipping_address' => json_encode($shippingAddress),
                'billing_address' => json_encode($shippingAddress),
                'shipping_cost' => session('shipping_rate', 0),
                'total_weight' => $totalWeight,
                'discount_amount' => number_format(session('discount_value', 0), 2, '.', ''),
                'tax_amount' => 0,
                'notes' => $checkoutData['notes'],
                'sub_total' => $vendorCartTotal
            ]);
        }
    }
    public function uniqueNumber()
    {
        do {
            $number = 'ORD-' . mt_rand(1000, 9999);
        } while (Order::where('order_number', $number)->exists());
        return $number;
    }
}
