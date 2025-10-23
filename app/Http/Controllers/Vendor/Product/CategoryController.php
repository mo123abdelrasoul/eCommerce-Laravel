<?php

namespace App\Http\Controllers\Vendor\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        $categories = Category::where('vendor_id', $vendor->id)->get();
        return view('vendor.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor_id = Auth::guard('vendors')->user()->id;
        $categories = Category::where('vendor_id', $vendor_id)->get();
        return view('vendor.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('vendor_id', Auth::guard('vendors')->id());
                }),
            ],
            'description' => 'nullable|string|max:1000',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|boolean',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        if (empty($validated['parent_id'])) {
            $validated['parent_id'] = NULL;
        }
        if (!empty($validated['image'])) {
            $validated['image'] = $request->file('image')->store('uploads', 'public');
        } else {
            $validated['image'] = NULL;
        }
        $vendor = Auth::guard('vendors')->user();
        if ($vendor) {
            $vendor_id = $vendor->id;
        }
        $store = Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'parent_id' => $validated['parent_id'],
            'image' => $validated['image'],
            'status' => $validated['status'],
            'vendor_id' => $vendor_id,
        ]);
        if ($store) {
            return back()->with('success', 'Category added successfully!');
        } else {
            return back()->with('error', 'Failed to add category. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lang, $id)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor_id = Auth::guard('vendors')->user()->id;
        $categories = Category::where('vendor_id', $vendor_id)->get();
        $category = Category::where('id', $id)->where('vendor_id', $vendor_id)->firstOrFail();
        if (!$category) {
            return back()->with('error', 'Category not found or you do not have permission to edit it.');
        }
        if ($category->parent_id && $category->parent_id == $id) {
            return back()->with('error', 'You cannot set a category as its own parent.');
        }
        if ($category->vendor_id != $vendor_id) {
            return back()->with('error', 'You do not have permission to edit this category.');
        }
        return view('vendor.categories.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lang, $id)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $category = Category::findOrFail($id);
        $vendor = Auth::guard('vendors')->user();
        if ($category->vendor_id != $vendor->id) {
            return back()->with('error', 'You do not have permission to update this category.');
        }
        if ($category->parent_id && $category->parent_id == $id) {
            return back()->with('error', 'You cannot set a category as its own parent.');
        }
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('vendor_id', Auth::guard('vendors')->id());
                })->ignore($id),
            ],
            'description' => 'nullable|string',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|boolean',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('uploads', 'public');
        } else {
            $validated['image'] = $category->image;
        }
        if (empty($validated['parent_id'])) {
            $validated['parent_id'] = NULL;
        }
        if ($validated['parent_id'] == $category->id) {
            return back()->with('error', 'You cannot set a category as its own parent.');
        }
        $store = $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'parent_id' => $validated['parent_id'],
            'image' => $validated['image'],
            'status' => $validated['status'],
            'vendor_id' => $category->vendor_id,
        ]);
        if ($store) {
            return back()->with('success', 'Category updated successfully!');
        } else {
            return back()->with('error', 'Failed to updated category. Please try again.');
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
        $category = Category::findOrFail($id);
        $vendor = Auth::guard('vendors')->user();
        if ($category->vendor_id != $vendor->id) {
            return back()->with('error', 'You do not have permission to delete this category.');
        }
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        try {
            $category->delete();
            return back()->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the category. Please try again.');
        }
    }
}
