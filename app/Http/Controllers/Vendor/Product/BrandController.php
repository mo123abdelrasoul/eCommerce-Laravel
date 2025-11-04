<?php

namespace App\Http\Controllers\Vendor\Product;

use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $search = request('search');
        $brands = Brand::where('status', true)->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('vendor.brands.index', compact('brands'));
    }
}
