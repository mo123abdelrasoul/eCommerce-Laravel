<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route(('vendor.login'));
        }
        $vendor = Auth::guard('vendors')->user();
        $ordersCount = DB::table('orders')->where('vendor_id', $vendor->id)->count();
        $productsCount = DB::table('products')->where('vendor_id', $vendor->id)->count();
        $revenue = DB::table('orders')->where('vendor_id', $vendor->id)->sum('total_amount');
        return view('vendor.profile.index', compact('vendor', 'ordersCount', 'productsCount', 'revenue'));
    }

    public function edit()
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $profile = Auth::guard('vendors')->user();
        return view('vendor.profile.edit', compact('profile'));
    }

    public function update(Request $request, $lang)
    {
        echo 'yes';
    }
}
