<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Order;
use Carbon\Carbon;
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
        $orders = Order::with(['customer:id,name'])->where('vendor_id', $vendor->id)->get();
        return view('vendor.orders.index', compact('orders'));
    }

    public function show($lang, $id)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        if ($vendor->id != $id) {
            abort(403, 'You are not allowed to access this order.');
        }
        if (intval($id)) {
            $vendor_authorized = DB::table('orders')->where('vendor_id', $vendor->id)->where('id', $id)->count();
            if ($vendor_authorized > 0) {
                $order_details = Order::where('id', $id)->first();
                $order_products = DB::table('order_items')->where('order_id', $id)->get();
                $customer_name = DB::table('users')->where('id', $order_details->customer_id)->value('name');
                return view('vendor.orders.show', compact('order_details', 'order_products', 'customer_name'));
            } else {
                return "UnAuthorized";
            }
        }
    }

    public function edit($lang, $id)
    {
        if (!Auth::guard('vendors')->check()) {
            redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        if ($vendor->id != $id) {
            abort(403, 'You are not allowed to access this order.');
        }
        if (intval($id)) {
            $vendor_authorized = DB::table('orders')->where('vendor_id', $vendor->id)->where('id', $id)->count();
            if ($vendor_authorized == 0) {
                return "UnAuthorized";
            }
        }
        $order_details = Order::where('id', $id)->first();
        return view('vendor.orders.edit', ['order' => $order_details]);
    }
    public function update(Request $request, $lang, $id)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        if ($vendor->id != $id) {
            abort(403, 'You are not allowed to access this order.');
        }
        if (intval($id)) {
            $vendor_authorized = DB::table('orders')->where('vendor_id', $vendor->id)->where('id', $id)->count();
            if ($vendor_authorized == 0) {
                return "UnAuthorized";
            }
        }
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(config('order.status')))],
            'payment_method' => ['required', Rule::in(array_keys(config('order.payment_method')))],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
        $order = Order::findOrFail($id);
        if ($order->shipping_cost !== $validated['shipping_cost']) {
            $total_amount = ($order->sub_total + $validated['shipping_cost']) - $order->discount_amount;
        } else {
            $total_amount = $order->total_amount;
        }
        $updated = $order->update([
            'status' => $validated['status'],
            'payment_method' => $validated['payment_method'],
            'shipping_cost' => $validated['shipping_cost'],
            'shipping_address' => $validated['shipping_address'],
            'notes' => $validated['notes'],
            'total_amount' => $total_amount,
        ]);
        if ($updated) {
            return back()->with('success', 'Order Updated successfully!');
        } else {
            return back()->with('error', 'Failed to Update the Order. Please try again.');
        }
    }
    public function destroy($lang, $id)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        if ($vendor->id != $id) {
            abort(403, 'You are not allowed to access this order.');
        }
        if (intval($id)) {
            $vendor_authorized = DB::table('orders')->where('vendor_id', $vendor->id)->where('id', $id)->count();
            if ($vendor_authorized == 0) {
                return "UnAuthorized";
            }
        }
        $order = Order::findOrFail($id);
        try {
            $order->delete();
            return back()->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the Order. Please try again.');
        }
    }
}
