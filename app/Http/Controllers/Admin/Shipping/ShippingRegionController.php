<?php

namespace App\Http\Controllers\Admin\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingRegion;
use Illuminate\Http\Request;

class ShippingRegionController extends Controller
{
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
        $regions = ShippingRegion::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->paginate(10);
        return view('admin.shipping.regions.index', compact('regions'));
    }

    public function create()
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $regions = ShippingRegion::all();
        return view('admin.shipping.regions.create', compact('regions'));
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
            'name' => 'required|string|max:255|min:2',
            'description' => 'nullable|max:255',
            'is_active' => 'required|in:0,1',
        ]);
        $region = ShippingRegion::create($data);
        if ($region) {
            return back()->with('success', 'Region created successfully!');
        }
        return back()->with('error', 'Failed to create the region. Please try again.');
    }

    public function edit($lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $region = ShippingRegion::findOrFail($id);
        return view('admin.shipping.regions.edit', compact('region'));
    }

    public function update(Request $request, $lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $region = ShippingRegion::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|min:2',
            'description' => 'nullable|max:255',
            'is_active' => 'required|in:0,1',
        ]);
        $update = $region->update($data);
        if ($update) {
            return back()->with('success', 'Region Updated successfully!');
        }
        return back()->with('error', 'Failed to Update the region. Please try again.');
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
        $region = ShippingRegion::findOrFail($id);
        try {
            $region->delete();
            return back()->with('success', 'Region deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the region. Please try again.');
        }
    }
}
