<?php

namespace App\Http\Controllers\Customer\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index($lang)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            $products = collect();
            return view('customer.cart.index', compact('cart', 'products'))
                ->with('error', __('Your cart is empty. Please add items before checkout.'));
        }
        $products = Product::select('id', 'name', 'image', 'price')
            ->whereIn('id', array_keys($cart))
            ->get();
        return view('customer.cart.index', compact('cart', 'products'));
    }

    public function add($lang, Request $request)
    {
        $cart = Session::get('cart', []);
        $productId = $request->product_id;
        $quantity = max(1, $request->quantity ?? 1);
        $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;
        Session::put('cart', $cart);
        $products = Product::select('id', 'name', 'image', 'price')->whereIn('id', array_keys($cart))->get();
        $total = 0;
        foreach ($products as $product) {
            $product->formatted_price = format_currency($product->price);
            $product->formatted_line_total = format_currency($product->price * $cart[$product->id]);
            $total += $product->price * $cart[$product->id];
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully!',
            'cartCount' => count($cart),
            'cart' => $cart,
            'products' => $products,
            'cartTotal' => $total,
            'formatted' => [
                'cartTotal' => format_currency($total)
            ]
        ]);
    }
    public function update(Request $request)
    {
        $cart = Session::get('cart', []);
        $items = $request->input('items', []);
        if (empty($items)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No items to update.',
            ], 400);
        }
        foreach ($items as $item) {
            $productId = $item['product_id'] ?? null;
            $quantity = isset($item['quantity']) ? (int) $item['quantity'] : 1;
            if (!$productId || !isset($cart[$productId])) {
                continue;
            }
            $quantity = max(1, $quantity);
            $cart[$productId] = $quantity;
        }
        Session::put('cart', $cart);
        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cart[$product->id];
        }
        return;
    }
    public function delete($lang, Request $request)
    {
        $productId = $request->product_id;
        $cart = Session::get('cart', []);
        $total = 0;
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        // Always return the updated state even if item wasn't found (just in case)
        $products = Product::select('id', 'name', 'image', 'price')->whereIn('id', array_keys($cart))->get();
        
        foreach ($products as $product) {
            $product->formatted_price = format_currency($product->price);
            $product->formatted_line_total = format_currency($product->price * $cart[$product->id]);
            $total += $product->price * $cart[$product->id];
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Item deleted successfully!',
            'cartCount' => count($cart),
            'cart' => $cart,
            'products' => $products,
            'cartTotal' => $total,
            'formatted' => [
                'cartTotal' => format_currency($total)
            ]
        ]);
    }

    public function getData($lang)
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        if (empty($cart)) {
            return response()->json([
                'status' => 'success',
                'cartCount' => 0,
                'cart' => [],
                'products' => [],
                'cartTotal' => 0,
                'formatted' => [
                    'cartTotal' => format_currency(0)
                ]
            ]);
        }

        $products = Product::select('id', 'name', 'image', 'price')->whereIn('id', array_keys($cart))->get();
        
        foreach ($products as $product) {
            $product->formatted_price = format_currency($product->price);
            $product->formatted_line_total = format_currency($product->price * $cart[$product->id]);
            $total += $product->price * $cart[$product->id];
        }

        return response()->json([
            'status' => 'success',
            'cartCount' => count($cart),
            'cart' => $cart,
            'products' => $products,
            'cartTotal' => $total,
            'formatted' => [
                'cartTotal' => format_currency($total)
            ]
        ]);
    }
}
