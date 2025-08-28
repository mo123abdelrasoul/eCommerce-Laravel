<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\table;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        $vendor_id = $vendor->id;
        $products = Product::where('vendor_id', $vendor_id)->get();
        return view('vendor.products.index', compact('products', 'vendor_id'));
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $cats = Category::select('id', 'name')->get();
        $vendor = Auth::guard('vendors')->user();
        $vendor_id = $vendor->id;
        return view('vendor.products.create', compact('cats', 'vendor_id'));
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'sku' => 'required|unique:products,sku|max:8',
            'discount' => 'nullable|numeric|min:0',
            'vendor_id' => 'required|exists:vendors,id',
            'tags' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        if (!empty($validated['image'])) {
            $imgPath = $request->file('image')->store('uploads', 'public');
        } else {
            $imgPath = null;
        }
        $desc = strip_tags($validated['description']);
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
        $store = DB::table('products')->insert([
            'name' => $validated['name'],
            'description' => $desc,
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'category_id' => $validated['category_id'],
            'status' => $validated['status'],
            'image' => $imgPath,
            'sku' => $validated['sku'],
            'discount' => $validated['discount'],
            'vendor_id' => $validated['vendor_id'],
            'tags' => $tags,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        if ($store) {
            return back()->with('success', 'Product added successfully!');
        } else {
            return back()->with('error', 'Failed to add product. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($lang, $id)
    {
        if (!auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        $vendor_id = $vendor->id;
        $product = Product::findOrFail($id);
        if ($product->vendor_id != $vendor_id) {
            abort(403, 'You are not allowed to access this product.');
        }
        return view('vendor.products.show', compact('product', 'vendor_id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lang, $id)
    {
        if (!auth::guard('vendors')->check()) {
            redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
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
        $categories = Category::select('id', 'name')->get();
        return view('vendor.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lang, $id)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $product = Product::findOrFail($id);
        $vendor = Auth::guard('vendors')->user();
        if ($product->vendor_id != $vendor->id) {
            abort(403, 'You are not allowed to access this product.');
        }
        $validateData = $request->validate([
            'name' => 'required|max:255|min:3|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required',
            'sku' => 'required|max:8|unique:products,sku,' . $id,
            'discount' => 'nullable|numeric|min:0',
            'tags' => 'nullable|string',
            'description' => 'nullable|string',
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
