<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;

class CartController extends Controller
{
    public function index($lang)
    {
        $cart = Session::get('cart', []);
        $products = Product::select('id', 'name', 'image', 'price')->whereIn('id', array_keys($cart))->get();
        return view('user.cart.index', compact('cart', 'products'));
    }

    public function add($lang, Request $request)
    {
        $cart = Session::get('cart', []);
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        if ($quantity < 1) {
            $quantity = 1;
        }
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        Session::put('cart', $cart);
        $products = Product::select('id', 'name', 'image', 'price')->whereIn('id', array_keys($cart))->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully!',
            'cartCount' => count($cart),
            'cart' => $cart,
            'products' => $products
        ]);
        // return Redirect::back()->with('success', __('Product added to cart successfully!'));
    }
    public function update(Request $request)
    {
        $cart = Session::get('cart', []);
        $items = $request->input('items', []);
        foreach ($items as $item) {
            $productId = $item['product_id'] ?? null;
            $quantity = (int)($item['quantity'] ?? 1);
            if ($quantity < 1) {
                $quantity = 1;
            }
            if ($productId && isset($cart[$productId])) {
                $cart[$productId] = $quantity;
            }
        }
        Session::put('cart', $cart);
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
            $products = Product::select('id', 'price')->whereIn('id', array_keys($cart))->get();
            foreach ($products as $product) {
                $total += $product->price * $cart[$product->id];
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Item deleted successfully!',
                'cartCount' => count($cart),
                'cartTotal' => $total ?? 0
            ]);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'Failed to deleted Item!',
            'cartCount' => count($cart),
            'cartTotal' => $total ?? 0
        ]);
    }
}
