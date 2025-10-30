<?php

namespace App\Http\Controllers\Vendor\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{

    public function index()
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        $vendor = Auth::guard('vendors')->user();
        $search = request('search');
        $categories = Category::where('status', true)->whereNotNull('parent_id')->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->paginate(10);
        return view('vendor.categories.index', compact('categories'));
    }
}
