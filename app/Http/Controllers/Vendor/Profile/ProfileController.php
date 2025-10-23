<?php

namespace App\Http\Controllers\Vendor\Profile;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index()
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route(('vendor.login'));
        }
        $vendor = Auth::guard('vendors')->user();
        $orders_count = DB::table('orders')->where('vendor_id', $vendor->id)->count();
        $products_count = DB::table('products')->where('vendor_id', $vendor->id)->count();
        $revenue = DB::table('orders')->where('vendor_id', $vendor->id)->sum('total_amount');
        return view('vendor.profile.index', compact('vendor', 'orders_count', 'products_count', 'revenue'));
    }

    public function edit($lang, $profile)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $vendor = Auth::guard('vendors')->user();
        if ($vendor->id != $profile) {
            abort(403, 'You are not allowed to access this profile.');
        }
        return view('vendor.profile.edit', compact('vendor'));
    }

    public function update(Request $request, $lang, $profile)
    {
        if (!Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.login');
        }
        $authVendor = Auth::guard('vendors')->user();
        $vendor = Vendor::find($authVendor->id);
        if ($vendor->id != $profile) {
            abort(403, 'You are not allowed to access this profile.');
        }
        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:vendors,email,' . $vendor->id,
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'phone' => 'required|string|max:15|regex:/^[0-9]+$/|unique:vendors,phone,' . $vendor->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('avatar')) {
            if ($vendor->avatar && Storage::disk('public')->exists($vendor->avatar)) {
                Storage::disk('public')->delete($vendor->avatar);
            }
            $imgPath = $request->file('avatar')->store('uploads/vendors', 'public');
        } else {
            $imgPath = $vendor->avatar;
        }
        if ($data['password'] == NULL) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        $data['avatar'] = $imgPath;

        $update = $vendor->update($data);
        if ($update) {
            return back()->with('success', 'Profile Updated successfully!');
        } else {
            return back()->with('error', 'Failed to Update the profile. Please try again.');
        }
    }
}
