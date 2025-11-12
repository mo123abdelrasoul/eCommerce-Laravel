<?php

namespace App\Http\Controllers\Vendor\Product;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $vendor;
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendors')->user();
            return $next($request);
        });
        $this->productService = $productService;
    }

    public function index()
    {
        $search = request('search');
        $products = Product::where('vendor_id', $this->vendor->id)
            ->when($search, fn($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', true)
            ->whereNotNull('parent_id')
            ->select('id', 'name')
            ->get();
        $brands = Brand::where('status', true)
            ->select('id', 'name')
            ->get();
        return view('vendor.products.create', [
            'cats' => $categories,
            'brands' => $brands,
            'vendor_id' => $this->vendor->id
        ]);
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
        $this->productService->create($validated, $request->file('image'));
        return back()->with('success', 'Product added successfully! Please wait for admin approval.');
    }

    public function show($lang, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorizeProduct($product);
        return view('vendor.products.show', compact('product'));
    }

    public function edit($lang, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorizeProduct($product);

        $categories = Category::where('status', true)
            ->whereNotNull('parent_id')
            ->select('id', 'name')
            ->get();

        $brands = Brand::where('status', true)
            ->select('id', 'name')
            ->get();

        return view('vendor.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function update(Request $request, $lang, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorizeProduct($product);

        $validated = $request->validate([
            'name' => 'required|max:255|min:3|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'sku' => 'required|max:8|min:6|unique:products,sku,' . $id,
            'discount' => 'nullable|numeric|min:0|max:100',
            'tags' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $this->productService->update($product, $validated, $request->file('image'));

        return back()->with('success', 'Product updated successfully!');
    }

    public function destroy($lang, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorizeProduct($product);

        $this->productService->delete($product);

        return back()->with('success', 'Product deleted successfully!');
    }

    private function authorizeProduct(Product $product)
    {
        if ($product->vendor_id != $this->vendor->id) {
            abort(403, 'You are not allowed to access this product.');
        }
    }
}
