<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class BrandController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        $search = request('search');
        $brands = Brand::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:brands,name',
            ],
            'description' => 'nullable|string|max:1000',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']);
        if (!empty($validated['image'])) {
            $validated['image'] = $request->file('image')->store('uploads/brands', 'public');
        } else {
            $validated['image'] = NULL;
        }
        $store = Brand::create([
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

    public function edit($lang, $id)
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        $brand = Brand::where('id', $id)->firstOrFail();
        if (!$brand) {
            return back()->with('error', 'Brand not found or you do not have permission to edit this brand.');
        }
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lang, $id)
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        $brand = Brand::findOrFail($id);
        if (!$brand) {
            return back()->with('error', 'Brand not found or you do not have permission to edit this brand.');
        }
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:brands,name,' . $id,
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
            $validated['image'] = $request->file('image')->store('uploads/brands', 'public');
        } else {
            $validated['image'] = $brand->image;
        }
        $store = $brand->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'slug' => $validated['slug'],
            'image' => $validated['image'],
            'status' => $validated['status'],
        ]);
        if ($store) {
            return back()->with('success', 'Brand updated successfully!');
        } else {
            return back()->with('error', 'Failed to updated brand. Please try again.');
        }
    }

    public function destroy($lang, $id)
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        $brand = Brand::findOrFail($id);
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
