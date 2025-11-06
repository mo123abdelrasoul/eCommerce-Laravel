<?php

namespace App\Http\Controllers\Vendor\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $vendor;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendors')->user();
            return $next($request);
        });
    }
    public function index()
    {
        dd($this->vendor);
        return view('vendor.profile.index', ['vendor' => $this->vendor]);
    }

    public function edit($lang)
    {
        return view('vendor.profile.edit', ['vendor' => $this->vendor]);
    }

    public function update(Request $request, $lang)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:vendors,email,' . $this->vendor->id,
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'phone' => 'required|string|max:15|regex:/^[0-9]+$/|unique:vendors,phone,' . $this->vendor->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('avatar')) {
            if ($this->vendor->avatar && Storage::disk('public')->exists($this->vendor->avatar)) {
                Storage::disk('public')->delete($this->vendor->avatar);
            }
            $imgPath = $request->file('avatar')->store('uploads/vendors', 'public');
        } else {
            $imgPath = $this->vendor->avatar;
        }
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        $data['avatar'] = $imgPath;

        $update = $this->vendor->update($data);
        if (!$update) {
            return back()->with('error', 'Failed to Update the profile. Please try again.');
        }
        return back()->with('success', 'Profile Updated successfully!');
    }
}
