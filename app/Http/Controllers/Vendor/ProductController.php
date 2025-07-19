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

use function Laravel\Prompts\table;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function DashboardProductsPage()
    {
        if (!auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        return view('vendor.products.index');
    }
    public function index()
    {
        //
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cats = Category::select('id', 'name')->get();
        $vendors = Vendor::select('id', 'name')->get();
        return view('vendor.products.create', compact('cats', 'vendors'));
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255|min:3|string',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required|min:0',
            'quantity' => 'required|min:0',
            'category_id' => 'required',
            'status' => 'required',
            'sku' => 'required|unique:products|max:8',
            'discount' => 'required|min:0',
            'vendor_id' => 'required',
            'out_of_stock' => 'required',
            'tags' => 'nullable|string',
            'description' => 'required',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $imgExtension = $validateData['image']->extension();
        $imgPath = $request->file('image')->store('uploads', 'public');
        $desc = strip_tags($validateData['description']);
        if (!empty($request['tags'])) {
            $tagsArray = explode(',', strip_tags($request['tags']));
            $tags = json_encode($tagsArray);
        } else {
            $tags = Null;
        }
        $store = DB::table('products')->insert([
            'name' => $validateData['name'],
            'description' => $desc,
            'price' => $validateData['price'],
            'quantity' => $validateData['quantity'],
            'category_id' => $validateData['category_id'],
            'status' => $validateData['status'],
            'image' => $imgPath,
            'sku' => $validateData['sku'],
            'discount' => $validateData['discount'],
            'vendor_id' => $validateData['vendor_id'],
            'tags' => $tags,
            'out_of_stock' => $validateData['out_of_stock'],
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lang, $id)
    {
        if (!auth::guard('vendors')->check()) {
            redirect()->route('vendor.login');
        }
        $product = Product::findOrFail($id);
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
        $validateData = $request->validate([
            'name' => 'required|max:255|min:3|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required|min:0',
            'quantity' => 'required|min:0',
            'category_id' => 'required',
            'status' => 'required',
            'sku' => 'required|max:8|unique:products,sku,' . $id,
            'discount' => 'required|min:0',
            'out_of_stock' => 'required',
            'tags' => 'nullable|string',
            'description' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $imgExtension = $validateData['image']->extension();
            $imgPath = $request->file('image')->store('uploads', 'public');
        } else {
            $imgPath = $product->image;
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
            'out_of_stock' => $validateData['out_of_stock'],
            'updated_at' => Carbon::now(),
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
        try {
            $product->delete();
            return back()->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the product. Please try again.');
        }
    }
}
