<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;



class CategoryController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        $admin = Auth::guard('admins')->user();
        $search = request('search');
        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        $admin_id = Auth::guard('admins')->user()->id;
        $categories = Category::get();
        return view('admin.categories.create', compact('categories'));
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
                'unique:categories,name'
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
            $validated['image'] = $request->file('image')->store('uploads/categories', 'public');
        } else {
            $validated['image'] = NULL;
        }
        $store = Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'parent_id' => $validated['parent_id'],
            'image' => $validated['image'],
            'status' => $validated['status'],
        ]);
        if ($store) {
            return back()->with('success', 'Category added successfully!');
        } else {
            return back()->with('error', 'Failed to add category. Please try again.');
        }
    }

    public function edit($lang, $id)
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $categories = Category::get();
        $category = Category::where('id', $id)->firstOrFail();
        if (!$category) {
            return back()->with('error', 'Category not found or you do not have permission to edit it.');
        }
        if ($category->parent_id && $category->parent_id == $id) {
            return back()->with('error', 'You cannot set a category as its own parent.');
        }
        return view('admin.categories.edit', compact('categories', 'category'));
    }

    public function update(Request $request, $lang, $id)
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $category = Category::findOrFail($id);
        if ($category->parent_id && $category->parent_id == $id) {
            return back()->with('error', 'You cannot set a category as its own parent.');
        }
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name,' . $id,
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
            $validated['image'] = $request->file('image')->store('uploads/categories', 'public');
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
        ]);
        if ($store) {
            return back()->with('success', 'Category updated successfully!');
        } else {
            return back()->with('error', 'Failed to updated category. Please try again.');
        }
    }

    public function destroy($lang, $id)
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $category = Category::findOrFail($id);
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
