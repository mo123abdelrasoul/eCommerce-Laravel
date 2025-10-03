<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\productRejection;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class ProductController extends Controller
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
        if (!$admin->hasRole('admin') || !$admin->can('manage products')) {
            abort(403, 'Unauthorized');
        }
        $products = Product::withTrashed()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($lang, $id)
    {
        if (!auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $admin = Auth::guard('admins')->user();
        if (!$admin->hasRole('admin') || !$admin->can('manage products')) {
            abort(403, 'Unauthorized');
        }
        $product = Product::withTrashed()->findOrFail($id);
        return view('admin.products.show', compact('product'));
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
        if (!$admin->hasRole('admin') || !$admin->can('manage products')) {
            abort(403, 'Unauthorized');
        }
        $product = Product::withTrashed()->findOrFail($id);
        $categories = Category::select('id', 'name')->where('vendor_id', $product->vendor_id)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lang, $id)
    {
        if (!auth::guard('admins')->check()) {
            return redirect()->route('admin.login');
        }
        $admin = Auth::guard('admins')->user();
        if (!$admin->hasRole('admin') || !$admin->can('manage products')) {
            abort(403, 'Unauthorized');
        }
        $product = Product::withTrashed()->findOrFail($id);
        $validateData = $request->validate([
            'name' => 'required|max:255|min:3|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'sku' => 'required|max:8|min:6|unique:products,sku,' . $id,
            'category_id' => 'required|exists:categories,id',
            'status' => 'required',
            'deleted' => 'nullable|in:0,1',
            'discount' => 'nullable|numeric|min:0|max:100',
            'tags' => 'nullable|string',
            'description' => 'nullable|string',
            'admin_feedback' => 'nullable|string',
        ]);
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imgPath = $request->file('image')->store('uploads', 'public');
        } else {
            $imgPath = $product->image;
        }
        if ($validateData['quantity'] == NULL) {
            $validateData['quantity'] = 0;
        }
        if ($validateData['discount'] == NULL) {
            $validateData['discount'] = 0;
        }
        $desc = strip_tags($validateData['description']);
        if (!empty($request['tags'])) {
            $tagsArray = explode(',', strip_tags($request['tags']));
            $tags = json_encode($tagsArray);
        } else {
            $tags = Null;
        }
        if ($request->boolean('deleted')) {
            $product->delete();
        } else {
            $product->restore();
        }
        unset($validateData['deleted']);
        if (empty($validateData['admin_feedback'])) {
            $validateData['admin_feedback'] = NULL;
        } else {
            $validateData['admin_feedback'] = strip_tags($validateData['admin_feedback']);
        }
        if (!empty($validateData['admin_feedback']) && $validateData['admin_feedback'] !== $product->admin_feedback) {
            $data = [
                'admin_feedback' => $validateData['admin_feedback'],
                'product_name' => $product->name,
                'vendor_name' => $product->vendor->name,
                'vendor_email' => $product->vendor->email,
            ];
            Mail::to($product->vendor->email)->queue(new productRejection($data));
        }
        $update = $product->update([
            'name' => $validateData['name'],
            'description' => $desc,
            'price' => $validateData['price'],
            'quantity' => $validateData['quantity'],
            'category_id' => $validateData['category_id'],
            'status' => $validateData['status'],
            'image' => $imgPath,
            'sku' => $validateData['sku'],
            'discount' => $validateData['discount'],
            'vendor_id' => $product->vendor_id,
            'tags' => $tags,
            'admin_feedback' => $validateData['admin_feedback'],
        ]);
        if ($update) {
            return back()->with('success', 'Product Updated successfully!');
        } else {
            return back()->with('error', 'Failed to Update the Product. Please try again.');
        }
    }

    public function restore($lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage products')) {
            abort(403, 'Unauthorized');
        }
        $product = Product::withTrashed()->findOrFail($id);
        if ($product->trashed()) {
            $product->restore();
            return back()->with('success', 'User restored successfully!');
        } else {
            return back()->with('info', 'User is not deleted.');
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
        if (!$admin->hasRole('admin') || !$admin->can('manage products')) {
            abort(403, 'Unauthorized');
        }
        $product = Product::withTrashed()->findOrFail($id);
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found.');
        }
        try {
            $product->delete();
            return back()->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the product. Please try again.');
        }
    }
}
