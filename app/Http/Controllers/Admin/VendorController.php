<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage vendors')) {
            abort(403, 'Unauthorized');
        }
        $vendors = Vendor::all();
        return view('admin.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage vendors')) {
            abort(403, 'Unauthorized');
        }
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage vendors')) {
            abort(403, 'Unauthorized');
        }
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage vendors')) {
            abort(403, 'Unauthorized');
        }
        $vendor = Vendor::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:vendors,email,' . $vendor->id,
            'status' => 'required|in:pending,confirmed,rejected,unknown',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'phone' => 'nullable|max:15|regex:/^[0-9]+$/',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company' => 'nullable|string|max:255',
        ]);
        if ($data['phone'] == NULL) {
            unset($data['phone']);
        }
        if ($data['company'] == NULL) {
            unset($data['company']);
        }
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

    public function pending()
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage vendors')) {
            abort(403, 'Unauthorized');
        }
        $vendors = Vendor::where('status', 'pending')->get();
        return view('admin.vendors.pending', compact('vendors'));
    }
    public function updateStatus(Request $request, $lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage vendors')) {
            abort(403, 'Unauthorized');
        }
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,rejected,unknown',
        ]);
        $vendor = Vendor::findOrFail($id);
        $vendor->status = 'confirmed';
        if ($vendor->save()) {
            return back()->with('success', 'Vendor confirmed successfully!');
        } else {
            return back()->with('error', 'Failed to confirm the vendor. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage vendors')) {
            abort(403, 'Unauthorized');
        }
        $vendor = Vendor::findOrFail($id);
        if ($vendor->avatar && Storage::disk('public')->exists($vendor->avatar)) {
            Storage::disk('public')->delete($vendor->avatar);
        }
        try {
            $vendor->delete();
            return back()->with('success', 'Vendor deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the vendor. Please try again.');
        }
    }
}
