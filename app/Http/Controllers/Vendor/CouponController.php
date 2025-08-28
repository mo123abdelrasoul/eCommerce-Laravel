<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        $coupons = Coupon::where('vendor_id', $vendor->id)->get();
        return view('vendor.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        $vendor_id = $vendor->id;
        return view('vendor.coupons.create', compact('vendor_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($lang, $coupon)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        $coupon_data = Coupon::where('vendor_id', $vendor->id)->where('id', $coupon)->first();
        if (!$coupon_data) {
            abort(404, 'No coupon found.');
        }
        if ($coupon_data->vendor_id != $vendor->id) {
            abort(403, 'You are not allowed to access this coupon.');
        }
        return view('vendor.coupons.show', ['coupon' => $coupon_data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lang, $coupon)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $coupon_data = Coupon::findOrFail($coupon);
        $vendor = Auth::guard('vendors')->user();
        if ($coupon_data->vendor_id != $vendor->id) {
            abort(403, 'You are not allowed to access this product.');
        }
        try {
            $coupon_data->delete();
            return back()->with('success', 'Coupon deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the coupon. Please try again.');
        }
    }
}
