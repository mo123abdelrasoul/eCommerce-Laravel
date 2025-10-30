<?php

namespace App\Http\Controllers\Vendor\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Brand;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        $search = request('search');
        $brands = Brand::where('status', true)->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->paginate(10);
        return view('vendor.brands.index', compact('brands'));
    }
}
