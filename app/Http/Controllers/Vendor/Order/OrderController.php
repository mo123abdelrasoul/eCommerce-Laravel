<?php

namespace App\Http\Controllers\Vendor\Order;

use App\Events\OrderUpdated;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\select;

class OrderController extends Controller
{
    public function index()
    {
        if (!auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        $search = request('search');
        $orders = Order::with(['customer:id,name'])->where('vendor_id', $vendor->id)->when($search, function ($query, $search) {
            return $query->where('order_number', 'like', "%{$search}%");
        })
            ->paginate(10);
        return view('vendor.orders.index', compact('orders'));
    }

    public function show($lang, $orderId)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $order = Order::where('id', $orderId)->first();

        $vendor = Auth::guard('vendors')->user();

        if ($vendor->id != $order->vendor_id) {
            abort(403, 'You are not allowed to access this order.');
        }
        if (intval($orderId)) {
            $vendor_authorized = DB::table('orders')->where('vendor_id', $vendor->id)->where('id', $orderId)->count();
            if ($vendor_authorized > 0) {
                $order_details = Order::where('id', $orderId)->first();
                $order_products = DB::table('order_items')->where('order_id', $orderId)->get();
                $customer_name = DB::table('users')->where('id', $order_details->customer_id)->value('name');
                return view('vendor.orders.show', compact('order_details', 'order_products', 'customer_name'));
            } else {
                return "UnAuthorized";
            }
        }
    }

    public function edit($lang, $orderId)
    {
        if (!Auth::guard('vendors')->check()) {
            redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        $order = Order::where('id', $orderId)->first();

        if ($vendor->id != $order->vendor_id) {
            abort(403, 'You are not allowed to access this order.');
        }
        if (intval($orderId)) {
            $vendor_authorized = DB::table('orders')->where('vendor_id', $vendor->id)->where('id', $orderId)->count();
            if ($vendor_authorized == 0) {
                return "UnAuthorized";
            }
        }
        return view('vendor.orders.edit', ['order' => $order]);
    }
    public function update(Request $request, $lang, $orderId)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        $order = Order::findOrFail($orderId);
        $vendor = Auth::guard('vendors')->user();
        if ($vendor->id !== $order->vendor_id) {
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
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $order = Order::findOrFail($orderId);
        $vendor = Auth::guard('vendors')->user();
        if ($vendor->id != $order->vendor_id) {
            abort(403, 'You are not allowed to access this order.');
        }
        if (intval($orderId)) {
            $vendor_authorized = DB::table('orders')->where('vendor_id', $vendor->id)->where('id', $orderId)->count();
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
