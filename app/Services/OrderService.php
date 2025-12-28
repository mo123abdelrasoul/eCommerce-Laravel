<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Services\OrderAmountService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\OrderItemService;

class OrderService extends Controller
{
    public function createPendingOrder($checkoutData, $coupon, $shipping, $vendorCart)
    {
        DB::beginTransaction();
        try {
            if (empty($vendorCart['products'])) {
                throw new \Exception('No vendor products found in cart.');
            }
            $paymentMethodService = new PaymentMethodService();
            $paymentMethodName = $paymentMethodService->getPaymentMethodCode($checkoutData['payment_method']);
            $userId = Auth::id();
            $shippingAddressService = new ShippingAddressService();
            $shippingAddress = $shippingAddressService->prepare($checkoutData);
            $orders = [];
            foreach ($vendorCart['products'] as $vendorId => $products) {
                $orderNumberService = new OrderNumberGeneratorService();
                $orderNumber = $orderNumberService->generate();
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
    ) {
        $amountService = new OrderAmountService();
        $amounts = $amountService->calculateTotal($vendorCart, $coupon, $shipping, $vendorId);
        $orderCreator = new OrderCreatorService();
        $order = $orderCreator->create([
            'customer_id' => $userId,
            'order_number' => $orderNumber,
            'total_amount' => $amounts['total_amount'],
            'payment_method' => $paymentMethodName,
            'shipping_address' => $shippingAddress,
            'billing_address' => $shippingAddress,
            'shipping_cost' => $amounts['shipping_cost'],
            'total_weight' => $amounts['total_weight'],
            'discount_amount' => $amounts['discount_amount'],
            'notes' => $checkoutData['notes'] ?? null,
            'vendor_id' => $vendorId,
            'sub_total' => $amounts['sub_total'],
            'shipping_method_id' => $checkoutData['shipping_method'],
            'coupon_id' => $amounts['coupon_id'] ?? null,
        ]);

        $orderItemService = new OrderItemService();
        $orderItemService->createItems($order, $products);
        return $order;
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
