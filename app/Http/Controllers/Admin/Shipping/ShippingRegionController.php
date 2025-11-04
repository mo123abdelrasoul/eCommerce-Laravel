<?php

namespace App\Http\Controllers\Admin\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingRegion;
use Illuminate\Http\Request;

class ShippingRegionController extends Controller
{
    public function index()
    {
        $search = request('search');
        $regions = ShippingRegion::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.shipping.regions.index', compact('regions'));
    }

    public function create()
    {
        $regions = ShippingRegion::all();
        return view('admin.shipping.regions.create', compact('regions'));
    }

    public function store($lang, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|min:2',
            'description' => 'nullable|max:255',
            'is_active' => 'required|in:0,1',
        ]);
        $region = ShippingRegion::create($data);
        if (!$region) {
            return back()->with('error', 'Failed to create the region. Please try again.');
        }
        return back()->with('success', 'Region created successfully!');
    }

    public function edit($lang, $id)
    {
        $region = ShippingRegion::findOrFail($id);
        return view('admin.shipping.regions.edit', compact('region'));
    }

    public function update(Request $request, $lang, $id)
    {
        $region = ShippingRegion::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|min:2',
            'description' => 'nullable|max:255',
            'is_active' => 'required|in:0,1',
        ]);
        $update = $region->update($data);
        if (!$update) {
            return back()->with('error', 'Failed to Update the region. Please try again.');
        }
        return back()->with('success', 'Region Updated successfully!');
    }

    public function destroy($lang, $id)
    {
        $region = ShippingRegion::findOrFail($id);
        try {
            $region->delete();
            return back()->with('success', 'Region deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the region. Please try again.');
        }
    }
}
