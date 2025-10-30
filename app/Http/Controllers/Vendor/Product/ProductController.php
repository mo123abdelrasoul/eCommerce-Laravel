<?php

namespace App\Http\Controllers\Vendor\Product;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\table;
use function Pest\Laravel\get;

class ProductController extends Controller
{
    public function index()
    {
        $vendor = Auth::guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        if (!$vendor->hasRole('vendor') && !$vendor->can('view own products')) {
            abort(403, 'Unauthorized');
        }
        $search = request('search');
        $products = Product::where('vendor_id', $vendor->id)->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->paginate(10);
        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        if (!auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        $vendor = Auth::guard('vendors')->user();
        if (!$vendor->hasRole('vendor') && !$vendor->can('create product')) {
            abort(403, 'Unauthorized');
        }
        $vendor_id = $vendor->id;
        $cats = Category::where('status', true)->whereNotNull('parent_id')->select('id', 'name')->get();
        $brands = Brand::where('status', true)->select('id', 'name')->get();
        return view('vendor.products.create', compact('cats', 'brands', 'vendor_id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'sku' => 'required|unique:products,sku|max:8|min:6',
            'discount' => 'nullable|numeric|min:0|max:100',
            'vendor_id' => 'required|exists:vendors,id',
            'tags' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        if (!empty($validated['image'])) {
            $imgPath = $request->file('image')->store('uploads/products', 'public');
        } else {
            $imgPath = null;
        }
        $desc = !empty($validated['description']) ? strip_tags($validated['description']) : null;
        if (!empty($request['tags'])) {
            $tagsArray = explode(',', strip_tags($request['tags']));
            $tags = json_encode($tagsArray);
        } else {
            $tags = Null;
        }
        if ($validated['quantity'] == NULL) {
            $validated['quantity'] = 0;
        }
        if ($validated['discount'] == NULL) {
            $validated['discount'] = 0;
        }
        $vendor = Auth::guard('vendors')->user();
        if ($vendor->id != $validated['vendor_id']) {
            abort(403, 'Unauthorized');
        }
        if (!$vendor->hasRole('vendor') && !$vendor->can('create product')) {
            abort(403, 'Unauthorized');
        }
        $store = DB::table('products')->insert([
            'name' => $validated['name'],
            'description' => $desc,
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
            'image' => $imgPath,
            'sku' => $validated['sku'],
            'discount' => $validated['discount'],
            'vendor_id' => $validated['vendor_id'],
            'tags' => $tags,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if ($store) {
            return back()->with('success', 'Product added successfully! Please wait for admin approval.');
        } else {
            return back()->with('error', 'Failed to add product. Please try again.');
        }
    }

    public function show($lang, $id)
    {
        if (!auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        if (!$vendor->can('view product')) {
            abort(403, 'Unauthorized');
        }
        $vendor_id = $vendor->id;
        $product = Product::findOrFail($id);
        if ($product->vendor_id != $vendor_id) {
            abort(403, 'You are not allowed to access this product.');
        }
        return view('vendor.products.show', compact('product', 'vendor_id'));
    }

    public function edit($lang, $id)
    {
        if (!auth::guard('vendors')->check()) {
            redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        if (!$vendor->can('edit product')) {
            abort(403, 'Unauthorized');
        }
        $vendor_id = $vendor->id;
        $product = Product::findOrFail($id);
        if ($product->vendor_id != $vendor_id) {
            abort(403, 'You are not allowed to access this product.');
        }
        if ($product->quantity == NULL) {
            $product->quantity = 0;
        }
        if ($product->discount == NULL) {
            $product->discount = 0;
        }
        $categories = Category::where('status', true)->whereNotNull('parent_id')->select('id', 'name')->get();
        $brands = Brand::where('status', true)->select('id', 'name')->get();
        return view('vendor.products.edit', ['product' => $product, 'categories' => $categories, 'brands' => $brands]);
    }

    public function update(Request $request, $lang, $id)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $product = Product::findOrFail($id);
        $vendor = Auth::guard('vendors')->user();
        if (!$vendor->can('edit product')) {
            abort(403, 'Unauthorized');
        }
        if ($product->vendor_id != $vendor->id) {
            abort(403, 'You are not allowed to access this product.');
        }
        $validateData = $request->validate([
            'name' => 'required|max:255|min:3|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'sku' => 'required|max:8|min:6|unique:products,sku,' . $id,
            'discount' => 'nullable|numeric|min:0|max:100',
            'tags' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imgPath = $request->file('image')->store('uploads/products', 'public');
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
        $update = $product->update([
            'name' => $validateData['name'],
            'description' => $desc,
            'price' => $validateData['price'],
            'quantity' => $validateData['quantity'],
            'category_id' => $validateData['category_id'],
            'brand_id' => $validateData['brand_id'],
            'image' => $imgPath,
            'sku' => $validateData['sku'],
            'discount' => $validateData['discount'],
            'vendor_id' => $product->vendor_id,
            'tags' => $tags,
        ]);
        if ($update) {
            return back()->with('success', 'Product Updated successfully!');
        } else {
            return back()->with('error', 'Failed to Update the Product. Please try again.');
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
        $product = Product::findOrFail($id);
        $vendor = Auth::guard('vendors')->user();
        if (!$vendor->can('delete product')) {
            abort(403, 'Unauthorized');
        }
        if ($product->vendor_id != $vendor->id) {
            abort(403, 'You are not allowed to access this product.');
        }
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        try {
            $product->delete();
            return back()->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the product. Please try again.');
        }
    }
}
