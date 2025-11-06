<?php

namespace App\Http\Controllers\Admin\Access;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $search = request('search');
        $permissions = Permission::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $guards = array_keys(config('auth.guards'));
        return view('admin.permissions.create', compact('guards'));
    }

    public function store($lang, Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->where(function ($query) use ($request) {
                    return $query->where('guard_name', $request->guard_name);
                })
            ],
            'guard_name' => [
                'required',
                'string',
                Rule::in(array_keys(config('auth.guards')))
            ]
        ]);
        $store = Permission::create($validated);
        if (!$store) {
            return back()->with('error', 'Failed to add permission. Please try again.');
        }
        return back()->with('success', 'Permission added successfully!');
    }

    public function edit($lang, $id)
    {
        $permission = Permission::where('id', $id)->first();
        $guards = array_keys(config('auth.guards'));
        return view('admin.permissions.edit', compact('permission', 'guards'));
    }

    public function update($lang, Request $request, $id)
    {
        $permission = Permission::find($id);
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($permission->id)->where(function ($query) use ($request) {
                    return $query->where('guard_name', $request->guard_name);
                })
            ],
            'guard_name' => [
                'required',
                'string',
                Rule::in(array_keys(config('auth.guards')))
            ]
        ]);
        $update = $permission->update($validated);
        if (!$update) {
            return back()->with('error', 'Failed to update permission. Please try again.');
        }
        return back()->with('success', 'Permission updated successfully!');
    }

    public function destroy($lang, $id)
    {
        $permission = Permission::findOrFail($id);
        try {
            $permission->delete();
            return back()->with('success', 'Permission deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the permission. Please try again.');
        }
    }
}
