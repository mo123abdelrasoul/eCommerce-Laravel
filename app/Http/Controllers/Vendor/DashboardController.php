<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendor = Auth::guard('vendors')->user();
        $orders = Order::with(['customer:id,name'])->where('vendor_id', $vendor->id)->get();
        $total_orders = 0;
        if (!$orders->isEmpty()) {
            foreach ($orders as $order) {
                $total_orders += $order->total_amount;
            }
        }
        $ordersCount = Order::where('vendor_id', $vendor->id)->count();
        $productsCount = Product::where('vendor_id', $vendor->id)->count();
        return view('vendor.dashboard', compact('orders', 'ordersCount', 'productsCount', 'total_orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
