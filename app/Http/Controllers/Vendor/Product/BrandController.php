<?php

namespace App\Http\Controllers\Vendor\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Brand;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor_id = Auth::guard('vendors')->user()->id;
        $brands = Brand::where('vendor_id', $vendor_id)->get();
        return view('vendor.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        return view('vendor.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor_id = Auth::guard('vendors')->user()->id;
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands')->where(function ($query) use ($vendor_id) {
                    return $query->where('vendor_id', $vendor_id);
                }),
            ],
            'description' => 'nullable|string|max:1000',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        if (!empty($validated['image'])) {
            $validated['image'] = $request->file('image')->store('uploads', 'public');
        } else {
            $validated['image'] = NULL;
        }
        $store = Brand::create([
            'vendor_id' => $vendor_id,
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'image' => $validated['image'],
            'status' => $validated['status'],
        ]);
        if ($store) {
            return back()->with('success', 'Brand added successfully!');
        } else {
            return back()->with('error', 'Failed to add brand. Please try again.');
        }
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
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor_id = Auth::guard('vendors')->user()->id;
        $brand = Brand::where('id', $id)->where('vendor_id', $vendor_id)->firstOrFail();
        if (!$brand) {
            return back()->with('error', 'Brand not found or you do not have permission to edit this brand.');
        }
        if ($brand->vendor_id != $vendor_id) {
            abort(403, 'You are not allowed to access this brand.');
        }
        return view('vendor.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lang, $id)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor_id = Auth::guard('vendors')->user()->id;
        $brand = Brand::findOrFail($id);
        if ($brand->vendor_id != $vendor_id) {
            abort(403, 'You are not allowed to access this brand.');
        }
        if (!$brand) {
            return back()->with('error', 'Brand not found or you do not have permission to edit this brand.');
        }
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands')->where(function ($query) use ($vendor_id) {
                    return $query->where('vendor_id', $vendor_id);
                })->ignore($brand->id),
            ],
            'description' => 'nullable|string|max:1000',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        if ($request->hasFile('image')) {
            if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                Storage::disk('public')->delete($brand->image);
            }
            $validated['image'] = $request->file('image')->store('uploads', 'public');
        } else {
            $validated['image'] = $brand->image;
        }
        $store = $brand->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'slug' => $validated['slug'],
            'image' => $validated['image'],
            'status' => $validated['status'],
            'vendor_id' => $vendor_id,
        ]);
        if ($store) {
            return back()->with('success', 'Brand updated successfully!');
        } else {
            return back()->with('error', 'Failed to updated brand. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lang, $id)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $brand = Brand::findOrFail($id);
        if ($brand->vendor_id != Auth::guard('vendors')->user()->id) {
            abort(403, 'You are not allowed to delete this brand.');
        }
        if ($brand->image && Storage::disk('public')->exists($brand->image)) {
            Storage::disk('public')->delete($brand->image);
        }
        try {
            $brand->delete();
            return back()->with('success', 'Brand deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the brand. Please try again.');
        }
    }
}
