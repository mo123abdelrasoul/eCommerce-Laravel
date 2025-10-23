<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService extends Controller
{
    public function createPendingOrder($checkoutData, $coupon, $shipping, $vendorCart)
    {
        DB::beginTransaction();
        try {
            if (empty($vendorCart['products'])) {
                throw new \Exception('No vendor products found in cart.');
            }
            $paymentMethodName = $this->getPaymentMethodName($checkoutData['payment_method']);
            $userId = Auth::id();
            $shippingAddress = $this->prepareShippingAddress($checkoutData);
            $shippingPolicyId = $this->getShippingPolicyId($checkoutData['shipping_method']);
            $orders = [];
            foreach ($vendorCart['products'] as $vendorId => $products) {
                $orderNumber = $this->uniqueNumber();
                $orders[] = $this->createVendorOrder(
                    $vendorId,
                    $products,
                    $checkoutData,
                    $coupon,
                    $shipping,
                    $vendorCart,
                    $orderNumber,
                    $paymentMethodName,
                    $userId,
                    $shippingAddress,
                    $shippingPolicyId
                );
            }
            DB::commit();
            $totalAmount = $this->calculateTotalAmount($orders);
            return [
                'success' => true,
                'orders' => $orders,
                'totalAmount' => $totalAmount,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function getPaymentMethodName($paymentMethodId)
    {
        return PaymentMethod::where('id', $paymentMethodId)->value('code')
            ?? throw new \Exception('Payment method not found.');
    }
    private function prepareShippingAddress($checkoutData)
    {
        return
            [
                "city" => $checkoutData['city'],
                "street_number" => $checkoutData['street_number'],
                "street_name" => $checkoutData['street_name'],
                "zip" => $checkoutData['zip_code']
            ];
    }
    private function getShippingPolicyId($methodId)
    {
        return ShippingMethod::where('id', $methodId)->value('shipping_policy_id');
    }
    private function createVendorOrder(
        $vendorId,
        $products,
        $checkoutData,
        $coupon,
        $shipping,
        $vendorCart,
        $orderNumber,
        $paymentMethodName,
        $userId,
        $shippingAddress,
        $shippingPolicyId
    ) {
        $totalCartAmount = array_sum($vendorCart['totals']);
        $discount = $coupon['discount'];
        $couponVendorId = $coupon['vendor_id'];
        $shippingCost = $shipping['rate'][$vendorId] ?? 0;
        $cartAmount = $vendorCart['totals'][$vendorId];
        $totalWeight = $shipping['total_weights'][$vendorId] ?? 0;
        $vendorDiscount = 0;
        if ($couponVendorId === null && $totalCartAmount > 0) {
            $vendorDiscount = ($discount * ($cartAmount / $totalCartAmount));
        } elseif ($couponVendorId == $vendorId) {
            $vendorDiscount = $discount;
        }
        $totalAmount = ($cartAmount + $shippingCost) - $vendorDiscount;

        if ((isset($coupon['vendor_id']) && $coupon['vendor_id'] == $vendorId) || empty($coupon['vendor_id'])) {
            $couponId = $coupon['id'] ?? null;
        } else {
            $couponId = null;
        }
        $order = Order::create([
            'customer_id' => $userId,
            'order_number' => $orderNumber,
            'status' => 'pending',
            'total_amount' => number_format($totalAmount, 2, '.', ''),
            'payment_status' => 'pending',
            'payment_method' => $paymentMethodName,
            'shipping_address' => json_encode($shippingAddress),
            'billing_address' => json_encode($shippingAddress),
            'shipping_cost' => number_format($shippingCost, 2, '.', ''),
            'total_weight' => $totalWeight,
            'discount_amount' => number_format($vendorDiscount, 2, '.', ''),
            'tax_amount' => 0,
            'notes' => $checkoutData['notes'] ?? null,
            'vendor_id' => $vendorId,
            'sub_total' => $cartAmount,
            'shipping_policy_id' => $shippingPolicyId,
            'shipping_method_id' => $checkoutData['shipping_method'],
            'coupon_id' => $couponId,
        ]);
        foreach ($products as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'product_price' => $item['discountedPrice'],
                'quantity' => $item['quantity'],
                'total_price' => $item['discountedPrice'] * $item['quantity'],
            ]);
        }
        return $order;
    }
    private function uniqueNumber()
    {
        do {
            $number = 'ORD-' . mt_rand(1000, 9999);
        } while (Order::where('order_number', $number)->exists());
        return $number;
    }
    private function calculateTotalAmount($orders)
    {
        $totalAmount = 0;
        foreach ($orders as $order) {
            $totalAmount += $order['total_amount'];
        }
        return $totalAmount;
    }
}
