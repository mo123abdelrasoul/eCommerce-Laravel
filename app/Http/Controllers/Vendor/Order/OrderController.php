<?php

namespace App\Http\Controllers\Vendor\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    protected $vendor;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendors')->user();
            return $next($request);
        });
    }

    public function index()
    {
        $search = request('search');

        $orders = Order::with(['customer:id,name'])
            ->where('vendor_id', $this->vendor->id)
            ->when($search, fn($q) => $q->where('order_number', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10);

        return view('vendor.orders.index', compact('orders'));
    }

    public function show($lang, $orderId)
    {
        $order = $this->findVendorOrder($orderId);
        $shipping_method_name = DB::table('shipping_methods')
            ->where('id', $order->shipping_method_id)
            ->value('name');

        return view('vendor.orders.show', [
            'order' => $order,
            'order_products' => $order->items,
            'customer_name' => $order->customer->name,
            'shipping_method_name' => $shipping_method_name,
        ]);
    }

    public function edit($lang, $orderId)
    {
        $order = $this->findVendorOrder($orderId);
        return view('vendor.orders.edit', compact('order'));
    }

    public function update(Request $request, $lang, $orderId)
    {
        $order = $this->findVendorOrder($orderId);

        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(config('order.status')))],
            'payment_status' => ['required', Rule::in(array_keys(config('order.payment_status')))],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $orderService = new OrderManagementService();
        $success = $orderService->updateOrder($order, $validated);

        return $success
            ? back()->with('success', 'Order updated successfully!')
            : back()->with('error', 'Failed to update the order. Please try again.');
    }

    public function destroy($lang, $orderId)
    {
        $order = $this->findVendorOrder($orderId);

        try {
            $order->delete();
            return back()->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the Order. Please try again.');
        }
    }

    protected function findVendorOrder($orderId): Order
    {
        $order = Order::with(['items', 'customer'])->findOrFail($orderId);

        if ($order->vendor_id !== $this->vendor->id) {
            abort(403, 'You are not allowed to access this order.');
        }

        return $order;
    }
}
