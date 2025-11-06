<?php

namespace App\Http\Controllers\Vendor\Order;

use App\Events\OrderUpdated;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
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
            ->when($search, function ($query, $search) {
                return $query->where('order_number', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('vendor.orders.index', compact('orders'));
    }

    public function show($lang, $orderId)
    {
        $order = Order::with('items', 'customer')->findOrFail($orderId);
        if ($order->vendor_id !== $this->vendor->id) {
            abort(403, 'You are not allowed to access this order.');
        }
        $shipping_method_name = DB::table('shipping_methods')
            ->where('id', $order->shipping_method_id)
            ->value('name');
        $order_products = $order->items;
        $customer_name = $order->customer->name;
        return view('vendor.orders.show', compact('order', 'order_products', 'customer_name', 'shipping_method_name'));
    }

    public function edit($lang, $orderId)
    {
        $order = Order::where('id', $orderId)->first();
        if ($this->vendor->id != $order->vendor_id) {
            abort(403, 'You are not allowed to access this order.');
        }
        if (intval($orderId)) {
            $vendor_authorized = DB::table('orders')
                ->where('vendor_id', $this->vendor->id)
                ->where('id', $orderId)->count();
            if ($vendor_authorized == 0) {
                return "UnAuthorized";
            }
        }
        return view('vendor.orders.edit', ['order' => $order]);
    }
    public function update(Request $request, $lang, $orderId)
    {
        $order = Order::findOrFail($orderId);
        if ($this->vendor->id !== $order->vendor_id) {
            abort(403, 'Unauthorized.');
        }
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(config('order.status')))],
            'payment_status' => ['required', Rule::in(array_keys(config('order.payment_status')))],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
        if ($order->shipping_cost !== $validated['shipping_cost']) {
            $total_amount = ($order->sub_total + $validated['shipping_cost']) - $order->discount_amount;
        } else {
            $total_amount = $order->total_amount;
        }
        $oldStatus = $order->status;
        $updated = $order->update([
            'status' => $validated['status'],
            'payment_status' => $validated['payment_status'],
            'shipping_cost' => $validated['shipping_cost'],
            'notes' => $validated['notes'],
            'total_amount' => $total_amount,
        ]);
        if (!$updated) {
            return back()->with('error', 'Failed to Update the Order. Please try again.');
        }
        if ($validated['status'] == 'completed' || $validated['status'] == 'cancelled') {
            event(new OrderUpdated($order, $oldStatus));
        }
        return back()->with('success', 'Order Updated successfully!');
    }
    public function destroy($lang, $orderId)
    {
        $order = Order::findOrFail($orderId);
        if ($this->vendor->id != $order->vendor_id) {
            abort(403, 'You are not allowed to access this order.');
        }
        if (intval($orderId)) {
            $vendor_authorized = DB::table('orders')
                ->where('vendor_id', $this->vendor->id)
                ->where('id', $orderId)->count();
            if ($vendor_authorized == 0) {
                return "UnAuthorized";
            }
        }
        try {
            $order->delete();
            return back()->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the Order. Please try again.');
        }
    }
}
