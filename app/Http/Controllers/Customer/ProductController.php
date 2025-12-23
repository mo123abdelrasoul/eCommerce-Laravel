<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($lang, $id)
    {
        $product = Product::with(['vendor:id,name', 'category:id,name', 'brand:id,name'])
            ->where('id', $id)
            ->firstOrFail();
        // Determine availability — don't immediately abort so we can display a friendly message
        $available = ($product->status === 'approved');

        if ($product->category_id) {
            $related = Product::where('category_id', $product->category_id)
                ->where('id', '<>', $product->id)
                ->where('status', 'approved')
                ->inRandomOrder()
                ->limit(4)
                ->get();
        } else {
            $related = collect();
        }
        return view('customer.product.show', compact('product', 'related', 'available'));
    }
}
