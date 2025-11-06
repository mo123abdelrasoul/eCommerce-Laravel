<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class VendorController extends Controller
{
    public function index()
    {
        $search = request('search');
        $vendors = Vendor::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function show($lang, $id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendors.show', compact('vendor'));
    }

    public function edit($lang, $id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, $lang, $id)
    {
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
        if (empty($data['phone'])) {
            unset($data['phone']);
        }
        if (empty($data['company'])) {
            unset($data['company']);
        }
        if ($request->hasFile('avatar')) {
            if ($vendor->avatar && Storage::disk('public')->exists($vendor->avatar)) {
                Storage::disk('public')->delete($vendor->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('uploads/vendors', 'public');
        } else {
            unset($data['avatar']);
        }
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        $update = $vendor->update($data);
        if (!$update) {
            return back()->with('error', 'Failed to Update the profile. Please try again.');
        }
        return back()->with('success', 'Profile Updated successfully!');
    }

    public function pending()
    {
        $search = request('search');
        $vendors = Vendor::where('status', 'pending')->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->paginate(10);
        return view('admin.vendors.pending', compact('vendors'));
    }
    public function updateStatus(Request $request, $lang, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,rejected,unknown',
        ]);
        $vendor = Vendor::findOrFail($id);
        $vendor->status = $data['status'];
        if (!$vendor->save()) {
            return back()->with('error', 'Failed to update the vendor status. Please try again.');
        }
        return back()->with('success', 'Vendor updated successfully!');
    }

    public function destroy($lang, $id)
    {
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


    public function showAssignRoleForm($lang, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $roles = Role::where('guard_name', 'vendors')->get();
        return view('admin.vendors.assignRole', compact('vendor', 'roles'));
    }

    public function assignRole($lang, Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);
        $vendor->syncRoles([$request->role]);
        return back()->with('success', 'Role assigned to vendor successfully!');
    }
}
