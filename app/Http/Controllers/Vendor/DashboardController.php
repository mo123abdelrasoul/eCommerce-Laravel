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
            ->get();
        $total_revenue = $orders->sum('total_amount');
        $ordersCount = $orders->count();
        $productsCount = Product::where('vendor_id', $vendor->id)->count();

        return view('vendor.dashboard', compact(
            'orders',
            'ordersCount',
            'productsCount',
            'total_revenue'
        ));
    }
}
