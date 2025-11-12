<?php

namespace App\Http\Controllers\Vendor\Shipping;

use App\Http\Controllers\Controller;
use App\Services\ShippingMethodService;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    protected $vendor;
    protected $shippingMethodService;

    public function __construct(ShippingMethodService $shippingMethodService)
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendors')->user();
            return $next($request);
        });

        $this->shippingMethodService = $shippingMethodService;
    }

    public function index()
    {
        $shippingMethods = $this->shippingMethodService->getActiveMethods();
        $vendorMethods = $this->shippingMethodService->getVendorMethods($this->vendor);
        return view('vendor.shipping.methods.index', compact('shippingMethods', 'vendorMethods'));
    }

    public function store(Request $request)
    {
        $methods = $request->input('methods', []);
        $success = $this->shippingMethodService->updateVendorMethods($this->vendor, $methods);

        return redirect()
            ->route('vendor.shipping.methods.index', app()->getLocale())
            ->with(
                $success ? 'success' : 'error',
                $success ? __('Shipping methods updated successfully!') : __('Failed to update shipping methods.')
            );
    }
}
