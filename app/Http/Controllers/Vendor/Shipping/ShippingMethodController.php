<?php

namespace App\Http\Controllers\Vendor\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    protected $vendor;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendors')->user();
            return $next($request);
        });
    }
    public function index()
    {
        $shipping_methods = ShippingMethod::Active()->get();
        $vendor_methods = $this->vendor->shippingMethods;
        return view('vendor.shipping.methods.index', compact('shipping_methods', 'vendor_methods'));
    }

    public function store($lang, Request $request)
    {
        $methods = $request->input('methods', []);
        $selectedMethodIds = collect($methods)
            ->filter(fn($item) => isset($item['enabled']))
            ->keys()
            ->toArray();
        $this->vendor->shippingMethods()->sync($selectedMethodIds);
        return redirect()
            ->route('vendor.shipping.methods.index', app()->getLocale())
            ->with('success', __('Shipping methods updated successfully!'));
    }
}
