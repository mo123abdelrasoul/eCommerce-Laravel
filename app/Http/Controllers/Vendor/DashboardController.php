<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $vendor = Auth::guard('vendors')->user();
        $orders = Order::with(['customer:id,name'])
            ->where('vendor_id', $vendor->id)
            ->take(8)
            ->get();
        $total_revenue = Order::where('vendor_id', $vendor->id)->sum('total_amount');
        $ordersCount = Order::where('vendor_id', $vendor->id)->count();
        $productsCount = Product::where('vendor_id', $vendor->id)->count();

        return view('vendor.dashboard', compact(
            'orders',
            'ordersCount',
            'productsCount',
            'total_revenue'
        ));
    }
}
