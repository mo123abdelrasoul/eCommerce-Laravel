<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Mail\productRejection;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::withTrashed()->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function show($lang, $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($lang, $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $lang, $id)
    {
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
        if (!$update) {
            return back()->with('error', 'Failed to Update the Product. Please try again.');
        }
        return back()->with('success', 'Product Updated successfully!');
    }

    public function restore($lang, $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        if (!$product->trashed()) {
            return back()->with('info', 'User is not deleted.');
        }
        $product->restore();
        return back()->with('success', 'User restored successfully!');
    }

    public function destroy($lang, $id)
    {
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
