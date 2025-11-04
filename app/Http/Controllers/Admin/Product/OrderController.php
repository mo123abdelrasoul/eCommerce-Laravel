<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $search = request('search');
        $orders = Order::with(['customer:id,name'])->when($search, function ($query, $search) {
            return $query->where('order_number', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($lang, $orderId)
    {
        $order = Order::with(['items', 'customer', 'vendor'])->findOrFail($orderId);
        $order_products = $order->items;
        $customer_name = $order->customer ? $order->customer->name : 'N/A';
        return view('admin.orders.show', compact('order', 'order_products', 'customer_name'));
    }

    public function edit($lang, $orderId)
    {
        $order = Order::with(['items', 'customer', 'vendor'])->findOrFail($orderId);
        return view('admin.orders.edit', compact('order'));
    }
    public function update(Request $request, $lang, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(config('order.status')))],
            'payment_method' => ['required', Rule::in(array_keys(config('order.payment_method')))],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', Rule::in(array_keys(config('order.payment_status')))],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
        $total_amount = $order->shipping_cost !== $validated['shipping_cost']
            ? ($order->sub_total + $validated['shipping_cost']) - $order->discount_amount
            : $order->total_amount;
        $updated = $order->update([
            'status' => $validated['status'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_status'],
            'shipping_cost' => $validated['shipping_cost'],
            'discount_amount' => $validated['discount_amount'],
            'notes' => $validated['notes'],
            'total_amount' => $total_amount,
        ]);
        if (!$updated) {
            return back()->with('error', 'Failed to update the order. Please try again.');
        }
        return back()->with('success', 'Order updated successfully!');
    }
    public function destroy($lang, $orderId)
    {
        $order = Order::findOrFail($orderId);
        try {
            $order->delete();
            return redirect()
                ->route('admin.orders.index', app()->getLocale())
                ->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the order. Please try again.');
        }
    }
}
