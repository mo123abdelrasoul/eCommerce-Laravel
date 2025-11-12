<?php

namespace App\Http\Controllers\Vendor\Profile;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $vendor;
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendors')->user();
            return $next($request);
        });

        $this->profileService = $profileService;
    }

    public function index()
    {
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

        $avatarFile = $request->file('avatar');

        $success = $this->profileService->updateVendor($this->vendor, $data, $avatarFile);

        return $success
            ? back()->with('success', 'Profile updated successfully!')
            : back()->with('error', 'Failed to update the profile. Please try again.');
    }
}
