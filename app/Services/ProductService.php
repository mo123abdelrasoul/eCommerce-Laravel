<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProductService
{

    public function create(array $data, ?UploadedFile $image = null): Product
    {
        $data['description'] = !empty($data['description']) ? strip_tags($data['description']) : null;
        $data['tags'] = !empty($data['tags']) ? json_encode(explode(',', strip_tags($data['tags']))) : null;
        $data['quantity'] = $data['quantity'] ?? 0;
        $data['discount'] = $data['discount'] ?? 0;
        $data['weight'] = isset($data['weight']) ? $data['weight'] : null;
        $data['width'] = isset($data['width']) ? $data['width'] : null;
        $data['height'] = isset($data['height']) ? $data['height'] : null;
        $data['length'] = isset($data['length']) ? $data['length'] : null;
        $data['image'] = $image ? $image->store('uploads/products', 'public') : null;
        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'] ?? null,
            'image' => $data['image'],
            'sku' => $data['sku'],
            'discount' => $data['discount'],
            'weight' => $data['weight'],
            'width' => $data['width'],
            'height' => $data['height'],
            'length' => $data['length'],
            'vendor_id' => $data['vendor_id'],
            'tags' => $data['tags'],
        ]);
        return $product;
    }

    public function update(Product $product, array $data, ?UploadedFile $image = null): Product
    {
        $data['description'] = !empty($data['description']) ? strip_tags($data['description']) : null;
        $data['tags'] = !empty($data['tags']) ? json_encode(explode(',', strip_tags($data['tags']))) : null;
        $data['quantity'] = $data['quantity'] ?? 0;
        $data['discount'] = $data['discount'] ?? 0;
        $data['weight'] = isset($data['weight']) ? $data['weight'] : $product->weight ?? null;
        $data['width'] = isset($data['width']) ? $data['width'] : $product->width ?? null;
        $data['height'] = isset($data['height']) ? $data['height'] : $product->height ?? null;
        $data['length'] = isset($data['length']) ? $data['length'] : $product->length ?? null;
        if ($image) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $image->store('uploads/products', 'public');
        } else {
            $data['image'] = $product->image;
        }
        $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'] ?? null,
            'image' => $data['image'],
            'sku' => $data['sku'],
            'discount' => $data['discount'],
            'weight' => $data['weight'],
            'width' => $data['width'],
            'height' => $data['height'],
            'length' => $data['length'],
            'tags' => $data['tags'],
        ]);
        return $product;
    }

    public function delete(Product $product): bool
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        return $product->delete();
    }
}
