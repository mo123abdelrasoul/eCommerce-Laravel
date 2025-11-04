<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Validation\Rule;


class CouponController extends Controller
{
    public function index()
    {
        $search = request('search');
        $coupons = Coupon::when($search, function ($query, $search) {
            return $query->where('code', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function show($lang, $coupon)
    {
        $coupon_data = Coupon::where('id', $coupon)->first();
        if (!$coupon_data) {
            abort(404, 'No coupon found.');
        }
        return view('admin.coupons.show', ['coupon' => $coupon_data]);
    }

    public function edit($lang, $coupon)
    {
        $coupon = Coupon::Where('id', $coupon)->first();
        return view('admin.coupons.edit', ['coupon' => $coupon]);
    }

    public function update(Request $request, $lang, $coupon)
    {
        $coupon = Coupon::Where('id', $coupon)->first();
        $validated = $request->validate([
            'code' => 'required|string|min:3|max:50|unique:coupons,code,' . $coupon->id,
            'description' => 'nullable|string|max:1000',
            'discount_type' => ['required', Rule::in(array_keys(config('coupon.discount_type')))],
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
            'approval_status' => ['required', Rule::in(array_keys(config('coupon.approval_status')))],
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
        $coupon->approval_status = $validated['approval_status'];
        $coupon->start_date = $validated['start_date'] ?? null;
        $coupon->end_date = $validated['end_date'] ?? null;
        try {
            $coupon->save();
            return back()->with('success', 'Coupon updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update the coupon. Please try again.');
        }
    }

    public function destroy($lang, $coupon)
    {
        $coupon_data = Coupon::findOrFail($coupon);
        try {
            $coupon_data->delete();
            return back()->with('success', 'Coupon deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the coupon. Please try again.');
        }
    }
}
