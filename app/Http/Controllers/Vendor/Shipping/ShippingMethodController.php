<?php

namespace App\Http\Controllers\Vendor\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use App\Models\VendorShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $vendor = auth()->guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        if (!$vendor->hasRole('vendor') || !$vendor->can('manage shipping methods')) {
            abort(403, 'Unauthorized');
        }
        $shipping_methods = ShippingMethod::Active()->get();
        $vendor_methods = $vendor->shippingMethods;
        return view('vendor.shipping.methods.index', compact('shipping_methods', 'vendor_methods'));
    }

    public function store($lang, Request $request)
    {
        $vendor = auth()->guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        if (!$vendor->hasRole('vendor') || !$vendor->can('manage shipping methods')) {
            abort(403, 'Unauthorized');
        }
        $methods = $request->input('methods', []);
        $selectedMethodIds = collect($methods)
            ->filter(fn($item) => isset($item['enabled']))
            ->keys()
            ->toArray();
        $vendor->shippingMethods()->sync($selectedMethodIds);
        return redirect()
            ->route('vendor.shipping.methods.index', app()->getLocale())
            ->with('success', __('Shipping methods updated successfully!'));
    }
}
