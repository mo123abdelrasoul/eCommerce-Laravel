<?php

namespace App\Http\Controllers\Admin\Access;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $search = request('search');
        $roles = Role::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $guards = array_keys(config('auth.guards'));
        $permissions = Permission::all()->groupBy('guard_name');
        return view('admin.roles.create', compact('permissions', 'guards'));
    }

    public function store($lang, Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->where(function ($query) use ($request) {
                    return $query->where('guard_name', $request->guard_name);
                })
            ],
            'guard_name' => [
                'required',
                'string',
                Rule::in(array_keys(config('auth.guards')))
            ],
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name'
        ]);
        try {
            $role = Role::create([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name']
            ]);
            $role->syncPermissions($validated['permissions']);
            return back()->with('success', 'Role added successfully!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to add role. Please try again' . $e);
        }
    }

    public function edit($lang, $id)
    {
        $role = Role::where('id', $id)->first();
        $guards = array_keys(config('auth.guards'));
        $permissions = Permission::where('guard_name', $role->guard_name)->get();
        $rolePermissions = $role->permissions()->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'guards', 'permissions', 'rolePermissions'));
    }

    public function getPermissions($lang, $guard)
    {
        $permissions = Permission::where('guard_name', $guard)->get();
        return response()->json($permissions);
    }

    public function update($lang, Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($role->id)->where(function ($query) use ($request) {
                    return $query->where('guard_name', $request->guard_name);
                })
            ],
            'guard_name' => [
                'required',
                'string',
                Rule::in(array_keys(config('auth.guards')))
            ],
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);
        try {
            $validated['permissions'] = Permission::whereIn('id', $validated['permissions'])
                ->where('guard_name', $validated['guard_name'])
                ->pluck('id')
                ->toArray();
            $role->update([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name']
            ]);
            $role->syncPermissions($validated['permissions']);
            return back()->with('success', 'Role updated successfully!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to update the role. Please try again' . $e);
        }
    }

    public function destroy($lang, $id)
    {
        $role = Role::findOrFail($id);
        try {
            $role->delete();
            return back()->with('success', 'Role deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the role. Please try again.');
        }
    }
}
