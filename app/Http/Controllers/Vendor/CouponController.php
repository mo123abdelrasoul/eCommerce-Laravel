<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        if ($vendor->id != $request->vendor_id) {
            abort(403, 'You are not allowed to access this coupon.');
        }
        $validated = $request->validate([
            'code' => 'required|string|min:3|max:50|unique:coupons,code',
            'description' => 'nullable|string|max:1000',
            'discount_type' => 'required|in:percentage,fixed_cart,fixed_product',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'applies_to_all_products' => 'required|boolean',
            'applies_to_all_categories' => 'required|boolean',
            'excluded_product_ids' => 'nullable|string|max:255',
            'excluded_category_ids' => 'nullable|string|max:255',
            'status' => 'required|in:active,expired,disabled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'vendor_id' => 'required|exists:vendors,id',
        ]);
        if (!empty($validated['excluded_product_ids'])) {
            $productIdsArray = array_map('trim', explode(',', $validated['excluded_product_ids']));
            foreach ($productIdsArray as $id) {
                if (!is_numeric($id) || intval($id) <= 0) {
                    return back()->withInput()->withErrors(['excluded_product_ids' => 'Each excluded product ID must be a positive integer.']);
                }
            }
            $validated['excluded_product_ids'] = json_encode($productIdsArray);
        }
        if (!empty($validated['excluded_category_ids'])) {
            $categoryIdsArray = array_map('trim', explode(',', $validated['excluded_category_ids']));
            foreach ($categoryIdsArray as $id) {
                if (!is_numeric($id) || intval($id) <= 0) {
                    return back()->withInput()->withErrors(['excluded_category_ids' => 'Each excluded category ID must be a positive integer.']);
                }
            }
            $validated['excluded_category_ids'] = json_encode($categoryIdsArray);
        }
        $coupon = new Coupon();
        $coupon->code = $validated['code'];
        $coupon->description = $validated['description'] ?? null;
        $coupon->discount_type = $validated['discount_type'];
        $coupon->discount_value = $validated['discount_value'];
        $coupon->max_discount = $validated['max_discount'] ?? null;
        $coupon->min_order_amount = $validated['min_order_amount'] ?? null;
        $coupon->max_order_amount = $validated['max_order_amount'] ?? null;
        $coupon->usage_limit = $validated['usage_limit'] ?? null;
        $coupon->usage_limit_per_user = $validated['usage_limit_per_user'] ?? null;
        $coupon->applies_to_all_products = $validated['applies_to_all_products'];
        $coupon->applies_to_all_categories = $validated['applies_to_all_categories'];
        $coupon->excluded_product_ids = $validated['excluded_product_ids'] ?? null;
        $coupon->excluded_category_ids = $validated['excluded_category_ids'] ?? null;
        $coupon->status = $validated['status'];
        $coupon->start_date = $validated['start_date'] ?? null;
        $coupon->end_date = $validated['end_date'] ?? null;
        $coupon->vendor_id = $validated['vendor_id'];
        try {
            $coupon->save();
            return back()->with('success', 'Coupon added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create the coupon. Please try again.');
        }
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
    public function edit($lang, $coupon)
    {
        if (!auth::guard('vendors')->check()) {
            redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        $vendor_id = $vendor->id;
        $coupon = Coupon::Where('id', $coupon)->where('vendor_id', $vendor->id)->first();
        if ($coupon->vendor_id !== $vendor_id) {
            abort(403, 'You are not allowed to access this product.');
        }
        return view('vendor.coupons.edit', ['coupon' => $coupon]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lang, $coupon)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        $coupon = Coupon::Where('id', $coupon)->where('vendor_id', $vendor->id)->first();
        if ($coupon->vendor_id != $vendor->id) {
            abort(403, 'You are not allowed to access this coupon.');
        }
        $validated = $request->validate([
            'code' => 'required|string|min:3|max:50|unique:coupons,code,' . $coupon->id,
            'description' => 'nullable|string|max:1000',
            'discount_type' => 'required|in:percentage,fixed_cart,fixed_product',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'applies_to_all_products' => 'required|boolean',
            'applies_to_all_categories' => 'required|boolean',
            'excluded_product_ids' => 'nullable|string|max:255',
            'excluded_category_ids' => 'nullable|string|max:255',
            'status' => 'required|in:active,expired,disabled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        if (!empty($validated['excluded_product_ids'])) {
            $productIdsArray = array_map('trim', explode(',', $validated['excluded_product_ids']));
            foreach ($productIdsArray as $id) {
                if (!is_numeric($id) || intval($id) <= 0) {
                    return back()->withInput()->withErrors(['excluded_product_ids' => 'Each excluded product ID must be a positive integer.']);
                }
            }
            $validated['excluded_product_ids'] = json_encode($productIdsArray);
        }

        if (!empty($validated['excluded_category_ids'])) {
            $categoryIdsArray = array_map('trim', explode(',', $validated['excluded_category_ids']));
            foreach ($categoryIdsArray as $id) {
                if (!is_numeric($id) || intval($id) <= 0) {
                    return back()->withInput()->withErrors(['excluded_category_ids' => 'Each excluded category ID must be a positive integer.']);
                }
            }
            $validated['excluded_category_ids'] = json_encode($categoryIdsArray);
        }

        $coupon->code = $validated['code'];
        $coupon->description = $validated['description'] ?? null;
        $coupon->discount_type = $validated['discount_type'];
        $coupon->discount_value = $validated['discount_value'];
        $coupon->max_discount = $validated['max_discount'] ?? null;
        $coupon->min_order_amount = $validated['min_order_amount'] ?? null;
        $coupon->max_order_amount = $validated['max_order_amount'] ?? null;
        $coupon->usage_limit = $validated['usage_limit'] ?? null;
        $coupon->usage_limit_per_user = $validated['usage_limit_per_user'] ?? null;
        $coupon->applies_to_all_products = $validated['applies_to_all_products'];
        $coupon->applies_to_all_categories = $validated['applies_to_all_categories'];
        $coupon->excluded_product_ids = $validated['excluded_product_ids'] ?? null;
        $coupon->excluded_category_ids = $validated['excluded_category_ids'] ?? null;
        $coupon->status = $validated['status'];
        $coupon->start_date = $validated['start_date'] ?? null;
        $coupon->end_date = $validated['end_date'] ?? null;
        try {
            $coupon->save();
            return back()->with('success', 'Coupon updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update the coupon. Please try again.');
        }
    }

    /*
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
