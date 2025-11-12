<?php

namespace App\Http\Controllers\Vendor\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingRegion;
use App\Models\VendorShippingRate;
use App\Services\ShippingRateService;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    protected $vendor;
    protected $shippingRateService;

    public function __construct(ShippingRateService $shippingRateService)
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendors')->user();
            return $next($request);
        });

        $this->shippingRateService = $shippingRateService;
    }

    public function index()
    {
        $methods = $this->vendor->shippingMethods;
        $regions = ShippingRegion::active()->get();
        $rates = VendorShippingRate::where('vendor_id', $this->vendor->id)
            ->with(['method', 'region'])
            ->get();

        return view('vendor.shipping.rates.index', compact('methods', 'regions', 'rates'));
    }

    public function store(Request $request)
    {
        if (!$request->has('rates') || empty($request->rates)) {
            VendorShippingRate::where('vendor_id', $this->vendor->id)->delete();
            return back()->with('success', 'All shipping rates have been deleted successfully.');
        }
        $validated = $request->validate([
            'rates' => 'required|array|min:1',
            'rates.*.region' => 'required|exists:shipping_regions,id',
            'rates.*.method' => 'required|exists:shipping_methods,id',
            'rates.*.min_weight' => 'required|numeric|min:0',
            'rates.*.max_weight' => 'nullable|numeric|min:0|gte:rates.*.min_weight',
            'rates.*.rate' => 'required|numeric|min:0',
        ], [], [
            'rates.*.region' => 'Region',
            'rates.*.method' => 'Method',
            'rates.*.min_weight' => 'Minimum weight',
            'rates.*.max_weight' => 'Maximum weight',
            'rates.*.rate' => 'Rate',
        ]);
        $success = $this->shippingRateService->updateVendorRates($this->vendor, $validated['rates']);
        return back()->with(
            $success ? 'success' : 'error',
            $success ? 'Shipping rates updated successfully.' : 'Something went wrong while saving shipping rates.'
        );
    }
}
