<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showCheckoutForm($lang)
    {
        $products = Product::select('id', 'name', 'image', 'price')->whereIn('id', array_keys(Session::get('cart', [])))->get();
        if ($products->isEmpty()) {
            return Redirect::route('cart.index', app()->getLocale())->with('error', __('Your cart is empty. Please add items to your cart before proceeding to checkout.'));
        }
        return view('user.checkout.index', compact('products'));
    }
    public function process($lang, Request $request)
    {

        $user = Auth::guard('web')->user();
        if (!$user) {
            return back()->with('error', 'You Must Login First.');
        }
        $cart = Session::get('cart', []);
        if (!empty($errors)) {
            return back()->withErrors(['cart' => $errors])->withInput();
        }
        $productIds = array_map('intval', array_keys($cart));
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id'); // keyBy لتحسين البحث
        $errors = [];
        foreach ($cart as $productId => $qty) {
            if (!isset($products[$productId])) {
                $errors[] = "Product with ID {$productId} not found.";
                continue;
            }
            $product = $products[$productId];
            $validQty = filter_var($qty, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
            if ($validQty === false) {
                $errors[] = "Invalid quantity for {$product->name}.";
                continue;
            }
            $qty = (int) $qty;
            if ($qty > (int) $product->quantity) {
                $errors[] = "Not enough stock for {$product->name}.";
                continue;
            }
            if ($product->status !== 'approved') {
                $errors[] = "{$product->name} is not available.";
                continue;
            }
        }
        if (!empty($errors)) {
            return back()->withErrors(['cart' => $errors]);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits_between:10,15',
            'address' => 'nullable|string|max:1000',
            'coupon_code' => 'nullable|string|max:255'
        ]);
    }
}
