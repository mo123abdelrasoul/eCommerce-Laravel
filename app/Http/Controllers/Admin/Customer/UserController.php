<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $search = request('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->withTrashed()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show($lang, $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($lang, $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $lang, $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
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
        if (empty($data['phone'])) {
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
        if (empty($data['password'])) {
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
        $user = User::withTrashed()->findOrFail($id);
        if (!$user->trashed()) {
            return back()->with('info', 'User is not deleted.');
        }
        $user->restore();
        return back()->with('success', 'User restored successfully!');
    }

    public function destroy($lang, $id)
    {
        $user = User::findOrFail($id);
        try {
            $user->delete();
            return back()->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the user. Please try again.');
        }
    }
}
