<?php

namespace App\Http\Controllers\Vendor\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use App\Models\ShippingRegion;
use App\Models\VendorShippingRate;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingRateController extends Controller
{
    public function index()
    {
        $vendor = auth()->guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        if (!$vendor->hasRole('vendor') || !$vendor->can('manage shipping rates')) {
            abort(403, 'Unauthorized');
        }
        $methods = $vendor->shippingMethods;
        $regions = ShippingRegion::active()->get();

        $rates = VendorShippingRate::where('vendor_id', $vendor->id)
            ->with(['method', 'region'])
            ->get();

        return view('vendor.shipping.rates.index', compact('methods', 'regions', 'rates'));
    }

    public function store($lang, Request $request)
    {
        $vendor = auth()->guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        if (!$vendor->hasRole('vendor') || !$vendor->can('manage shipping rates')) {
            abort(403, 'Unauthorized');
        }
        if (!$request->has('rates') || empty($request->rates)) {
            VendorShippingRate::where('vendor_id', $vendor->id)->delete();
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
        $newRates = collect($validated['rates']);
        try {
            DB::beginTransaction();
            VendorShippingRate::where('vendor_id', $vendor->id)->delete();
            foreach ($newRates as $rate) {
                VendorShippingRate::create([
                    'vendor_id' => $vendor->id,
                    'shipping_region_id' => $rate['region'],
                    'shipping_method_id' => $rate['method'],
                    'min_weight' => $rate['min_weight'],
                    'max_weight' => $rate['max_weight'] ?? null,
                    'rate' => $rate['rate'],
                ]);
            }
            DB::commit();
            return back()->with('success', 'Shipping rates updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Something went wrong while saving shipping rates. Please try again.');
        }
    }
}
