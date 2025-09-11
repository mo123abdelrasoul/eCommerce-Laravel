<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;




class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $admin = Auth::guard('admins')->user();
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $shipping_methods = ShippingMethod::all();
        return view('admin.shipping.index', compact('shipping_methods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $admin = Auth::guard('admins')->user();
        if (!$admin->hasRole('admin') && !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        return view('admin.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($lang, Request $request)
    {
        if (!auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $admin = Auth::guard('admins')->user();
        if (!$admin->hasRole('admin') && !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $validateData = $request->validate([
            'name' => 'required|max:255|min:3|string',
            'price' => 'required|min:0|numeric',
            'status' => 'required|boolean',
            'delivery_time' => ['required', Rule::in(array_keys(config('shipping.delivery_times')))],
        ]);
        $store = DB::table('shipping_methods')->insert([
            'name' => $validateData['name'],
            'price' => $validateData['price'],
            'status' => $validateData['status'],
            'delivery_time' => $validateData['delivery_time'],
        ]);
        if ($store) {
            return back()->with('success', 'Shipping Method added successfully!');
        } else {
            return back()->with('error', 'Failed to add Shipping Method. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lang, $id)
    {
        if (!auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $admin = Auth::guard('admins')->user();
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $shipping_method = ShippingMethod::findOrFail($id);
        return view('admin.shipping.edit', compact('shipping_method'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($lang, Request $request, string $id)
    {
        if (!auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $admin = Auth::guard('admins')->user();
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $shipping_method = ShippingMethod::findOrFail($id);
        $validateData = $request->validate([
            'name' => 'required|max:255|min:3|string',
            'price' => 'required|min:0|numeric',
            'vendor_id' => 'nullable',
            'status' => 'required|boolean',
            'delivery_time' => ['required', Rule::in(array_keys(config('shipping.delivery_times')))],
        ]);
        $update = $shipping_method->update([
            'name' => $validateData['name'],
            'price' => $validateData['price'],
            'status' => $validateData['status'],
            'delivery_time' => $validateData['delivery_time'],
        ]);

        if ($update) {
            return back()->with('success', 'Shipping Method Updated successfully!');
        } else {
            return back()->with('error', 'Failed to Update the Shipping Method. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lang, $id)
    {
        if (!auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $admin = Auth::guard('admins')->user();
        if (!$admin->hasRole('admin') && !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $shipping_method = ShippingMethod::findOrFail($id);
        try {
            $shipping_method->delete();
            return back()->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the product. Please try again.');
        }
    }
}
