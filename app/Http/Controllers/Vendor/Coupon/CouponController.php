<?php

namespace App\Http\Controllers\Vendor\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Services\CouponService;

class CouponController extends Controller
{
    protected $vendor;
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendors')->user();
            return $next($request);
        });

        $this->couponService = $couponService;
    }

    public function index()
    {
        $search = request('search');
        $coupons = Coupon::where('vendor_id', $this->vendor->id)
            ->when($search, fn($q) => $q->where('code', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10);

        return view('vendor.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $vendor_id = $this->vendor->id;
        return view('vendor.coupons.create', compact('vendor_id'));
    }

    public function store(Request $request)
    {
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

        $coupon = $this->couponService->createCoupon($validated);

        return $coupon
            ? back()->with('success', 'Coupon added successfully!')
            : back()->with('error', 'Failed to create the coupon. Please try again.');
    }

    public function show($lang, $couponId)
    {
        $coupon = Coupon::where('vendor_id', $this->vendor->id)
            ->findOrFail($couponId);

        return view('vendor.coupons.show', compact('coupon'));
    }

    public function edit($lang, $couponId)
    {
        $coupon = Coupon::where('id', $couponId)
            ->where('vendor_id', $this->vendor->id)
            ->firstOrFail();

        return view('vendor.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $lang, $couponId)
    {
        $coupon = Coupon::where('id', $couponId)
            ->where('vendor_id', $this->vendor->id)
            ->firstOrFail();

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
        $success = $this->couponService->updateCoupon($coupon, $validated);
        return $success
            ? back()->with('success', 'Coupon updated successfully!')
            : back()->with('error', 'Failed to update the coupon. Please try again.');
    }

    public function destroy($lang, $couponId)
    {
        $coupon = Coupon::where('id', $couponId)
            ->where('vendor_id', $this->vendor->id)
            ->firstOrFail();

        $success = $this->couponService->deleteCoupon($coupon);

        return $success
            ? back()->with('success', 'Coupon deleted successfully!')
            : back()->with('error', 'Failed to delete the coupon. Please try again.');
    }
}
