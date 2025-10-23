<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
        if (!$admin->hasRole('admin') || !$admin->can('manage users')) {
            abort(403, 'Unauthorized');
        }
        $users = User::withTrashed()->get();
        return view('admin.users.index', compact('users'));
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
        if (!$admin->hasRole('admin') || !$admin->can('manage users')) {
            abort(403, 'Unauthorized');
        }
        $user = User::withTrashed()->findOrFail($id);
        return view('admin.users.show', compact('user'));
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
        if (!$admin->hasRole('admin') || !$admin->can('manage users')) {
            abort(403, 'Unauthorized');
        }
        $user = User::withTrashed()->findOrFail($id);
        return view('admin.users.edit', compact('user'));
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
        if (!$admin->hasRole('admin') || !$admin->can('manage users')) {
            abort(403, 'Unauthorized');
        }
        $user = User::withTrashed()->findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:vendors,email,' . $user->id,
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|max:15|regex:/^[0-9]+$/',
        ]);
        if ($data['phone'] == NULL) {
            unset($data['phone']);
        }
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('uploads/users', 'public');
        } else {
            unset($data['avatar']);
        }
        if ($data['password'] == NULL) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        $update = $user->update($data);
        if ($update) {
            return back()->with('success', 'Profile Updated successfully!');
        } else {
            return back()->with('error', 'Failed to Update the profile. Please try again.');
        }
    }

    public function restore($lang, $id)
    {
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage users')) {
            abort(403, 'Unauthorized');
        }
        $user = User::withTrashed()->findOrFail($id);
        if ($user->trashed()) {
            $user->restore();
            return back()->with('success', 'User restored successfully!');
        } else {
            return back()->with('info', 'User is not deleted.');
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
        if (!$admin->hasRole('admin') || !$admin->can('manage users')) {
            abort(403, 'Unauthorized');
        }
        $user = User::findOrFail($id);
        try {
            $user->delete();
            return back()->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the user. Please try again.');
        }
    }
}
