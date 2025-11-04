<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $admin;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->admin = auth()->guard('admins')->user();
            return $next($request);
        });
    }
    public function index()
    {
        return view('admin.profile.index', ['admin' => $this->admin]);
    }

    public function edit($lang)
    {
        return view('admin.profile.edit', ['admin' => $this->admin]);
    }

    public function update(Request $request, $lang)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $this->admin->id,
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'phone' => 'required|string|max:15|regex:/^[0-9]+$/|unique:admins,phone,' . $this->admin->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('avatar')) {
            if ($this->admin->avatar && $this->admin->avatar !== 'uploads/admins/default.png' && Storage::disk('public')->exists($this->admin->avatar)) {
                Storage::disk('public')->delete($this->admin->avatar);
            }
            $imgPath = $request->file('avatar')->store('uploads/admins', 'public');
        } else {
            $imgPath = $this->admin->avatar;
        }
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        $data['avatar'] = $imgPath;

        $update = $this->admin->update($data);
        if (!$update) {
            return back()->with('error', 'Failed to Update the profile. Please try again.');
        }
        return back()->with('success', 'Profile Updated successfully!');
    }
}
