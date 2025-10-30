<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        $admin = Auth::guard('admins')->user();
        return view('admin.profile.index', compact('admin'));
    }

    public function edit($lang, $profile)
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        $admin = Auth::guard('admins')->user();
        if ($admin->id != $profile) {
            abort(403, 'You are not allowed to access this profile.');
        }
        return view('admin.profile.edit', compact('admin'));
    }


    public function update(Request $request, $lang, $profile)
    {
        if (!Auth::guard('admins')->check()) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        $authAdmin = Auth::guard('vendors')->user();
        $admin = Admin::find($authAdmin->id);
        if ($admin->id != $profile) {
            abort(403, 'You are not allowed to access this profile.');
        }
        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:vendors,email,' . $admin->id,
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'phone' => 'required|string|max:15|regex:/^[0-9]+$/|unique:vendors,phone,' . $admin->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }
            $imgPath = $request->file('avatar')->store('uploads/admins', 'public');
        } else {
            $imgPath = $admin->avatar;
        }
        if ($data['password'] == NULL) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        $data['avatar'] = $imgPath;

        $update = $admin->update($data);
        if ($update) {
            return back()->with('success', 'Profile Updated successfully!');
        } else {
            return back()->with('error', 'Failed to Update the profile. Please try again.');
        }
    }
}
