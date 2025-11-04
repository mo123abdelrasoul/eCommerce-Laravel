<?php

namespace App\Http\Controllers\Admin\Shipping;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ShippingRegion;
use Illuminate\Http\Request;

class ShippingCityController extends Controller
{

    public function index()
    {
        $search = request('search');
        $cities = City::with(['region:id,name'])->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.shipping.cities.index', compact('cities'));
    }

    public function create($lang)
    {
        $regions = ShippingRegion::select('id', 'name')->get();
        return view('admin.shipping.cities.create', compact('regions'));
    }

    public function store($lang, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|min:2',
            'region_id' => 'required|exists:shipping_regions,id',
            'is_active' => 'required|in:0,1',
        ]);
        $city = new City();
        $city->name = $data['name'];
        $city->region_id = $data['region_id'];
        $city->is_active = $data['is_active'];
        if (!$city->save()) {
            return back()->with('error', 'Failed to create the city. Please try again.');
        }
        return back()->with('success', 'City created successfully!');
    }

    public function edit($lang, $id)
    {
        $city = City::findOrFail($id);
        $regions = ShippingRegion::select('id', 'name')->get();
        return view('admin.shipping.cities.edit', compact('city', 'regions'));
    }

    public function update(Request $request, $lang, $id)
    {
        $city = City::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|min:2',
            'region_id' => 'required|exists:shipping_regions,id',
            'is_active' => 'required|in:0,1',
        ]);
        $update = $city->update($data);
        if (!$update) {
            return back()->with('error', 'Failed to Update the city. Please try again.');
        }
        return back()->with('success', 'City Updated successfully!');
    }

    public function destroy($lang, $id)
    {
        $city = City::findOrFail($id);
        try {
            $city->delete();
            return back()->with('success', 'City deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the city. Please try again.');
        }
    }
}
