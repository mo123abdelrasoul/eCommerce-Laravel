<?php

namespace App\Http\Controllers\Admin\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $search = request('search');
        $shipping_methods = ShippingMethod::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.shipping.methods.index', compact('shipping_methods'));
    }

    public function create()
    {
        return view('admin.shipping.methods.create');
    }

    public function store($lang, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255|unique:shipping_methods,name',
            'description' => 'nullable|string|max:1000',
            'delivery_time' => 'required|integer|min:1|max:30',
            'is_active' => 'required|boolean',
        ]);
        $method = ShippingMethod::create($data);
        if (!$method) {
            return back()->with('error', 'Failed to create the method. Please try again.');
        }
        return back()->with('success', 'Method created successfully!');
    }

    public function edit($lang, $id)
    {
        $shipping_method = ShippingMethod::findOrFail($id);
        return view('admin.shipping.methods.edit', compact('shipping_method'));
    }

    public function update($lang, Request $request, string $id)
    {
        $shipping_method = ShippingMethod::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255|unique:shipping_methods,name,' . $id,
            'description' => 'nullable|string|max:1000',
            'delivery_time' => 'required|integer|min:1|max:30',
            'is_active' => 'required|boolean',
        ]);
        $method = $shipping_method->update($data);
        if (!$method) {
            return back()->with('error', 'Failed to Update the Method. Please try again.');
        }
        return back()->with('success', 'Method Updated successfully!');
    }

    public function destroy($lang, $id)
    {
        $shipping_method = ShippingMethod::findOrFail($id);
        try {
            $shipping_method->delete();
            return back()->with('success', 'Method deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the method. Please try again.');
        }
    }
}
