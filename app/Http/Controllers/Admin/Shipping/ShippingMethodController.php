<?php

namespace App\Http\Controllers\Admin\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $search = request('search');
        $shipping_methods = ShippingMethod::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->paginate(10);
        return view('admin.shipping.methods.index', compact('shipping_methods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        return view('admin.shipping.methods.create');
    }

    public function store($lang, Request $request)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255|unique:shipping_methods,name',
            'description' => 'nullable|string|max:1000',
            'delivery_time' => 'required|integer|min:1|max:30',
            'is_active' => 'required|boolean',
        ]);
        $method = ShippingMethod::create($data);
        if ($method) {
            return back()->with('success', 'Method created successfully!');
        }
        return back()->with('error', 'Failed to create the method. Please try again.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $shipping_method = ShippingMethod::findOrFail($id);
        return view('admin.shipping.methods.edit', compact('shipping_method'));
    }

    public function update($lang, Request $request, string $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $shipping_method = ShippingMethod::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255|unique:shipping_methods,name,' . $id,
            'description' => 'nullable|string|max:1000',
            'delivery_time' => 'required|integer|min:1|max:30',
            'is_active' => 'required|boolean',
        ]);
        $method = $shipping_method->update($data);
        if ($method) {
            return back()->with('success', 'Method Updated successfully!');
        }
        return back()->with('error', 'Failed to Update the Method. Please try again.');
    }

    public function destroy($lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $shipping_method = ShippingMethod::findOrFail($id);
        try {
            $shipping_method->delete();
            return back()->with('success', 'Method deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the method. Please try again.');
        }
    }
}
