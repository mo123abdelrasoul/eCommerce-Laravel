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
        $products = Product::select('id', 'image', 'price')->whereIn('id', array_keys($cart))->get();
        return view('user.cart.index', compact('cart', 'products'));
    }

    public function add($lang, Request $request)
    {
        $cart = Session::get('cart', []);
        $productId = $request->id;
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        Session::put('cart', $cart);
        return Redirect::back()->with('success', __('Product added to cart successfully!'));
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
    public function delete($lang, $id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            return Redirect::back();
        }
        return Redirect::back()->with('error', __('Product not found in cart.'));
    }
}
