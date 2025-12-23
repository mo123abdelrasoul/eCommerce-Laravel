<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        $orders = Order::where('customer_id', $user->id)->orderBy('created_at', 'desc')->withCount('items')->get();
        return view('customer.profile.index', compact('user', 'orders'));
    }
}
