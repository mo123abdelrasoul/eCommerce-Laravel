<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $search = request('search');
        $admins = Admin::with('roles')->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->where('id', '!=', auth('admins')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
        ]);

        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('admin.admins.index', app()->getLocale())->with('success', 'Admin created successfully!');
    }

    public function edit($lang, $admin)
    {
        $admin = Admin::findOrFail($admin);

        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, $lang, $adminId)
    {
        $admin = Admin::findOrFail($adminId);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|string|min:8',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $admin->update($data);

        return back()->with('success', 'Admin updated successfully!');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return back()->with('success', 'Admin deleted successfully!');
    }

    public function assignRoleForm($lang, $id)
    {
        $admin = Admin::findOrFail($id);
        $roles = Role::all();
        return view('admin.admins.assign-role', compact('admin', 'roles'));
    }

    public function assignRole($lang, Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $data = $request->validate([
            'role' => 'required|string|exists:roles,name'
        ]);

        $admin->syncRoles($data['role']);
        return back()->with('success', 'Role assigned successfully!');
    }
}
