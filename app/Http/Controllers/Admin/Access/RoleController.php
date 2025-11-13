<?php

namespace App\Http\Controllers\Admin\Access;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $roles = $this->service->list($request->get('search'));
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $guards = $this->service->getGuards();
        $permissions = \Spatie\Permission\Models\Permission::all()->groupBy('guard_name');
        return view('admin.roles.create', compact('permissions', 'guards'));
    }

    public function store(RoleStoreRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return back()->with('success', 'Role added successfully!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to add role. Please try again.');
        }
    }

    public function edit($lang, $id)
    {
        $role = $this->service->find($id);
        $guards = $this->service->getGuards();
        $permissions = $this->service->getPermissionsByGuard($role->guard_name);
        $rolePermissions = $role->permissions()->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'guards', 'permissions', 'rolePermissions'));
    }

    public function update($lang, RoleUpdateRequest $request, $id, RoleService $roleService)
    {
        try {
            $roleService->update($id, $request->validated());
            return back()->with('success', 'Role updated successfully!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to update the role. Please try again. ' . $e->getMessage());
        }
    }

    public function destroy($lang, $id)
    {
        try {
            $role = $this->service->find($id);
            $this->service->delete($role);
            return back()->with('success', 'Role deleted successfully!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to delete the role. Please try again.');
        }
    }

    public function getPermissions($lang, $guard)
    {
        $permissions = $this->service->getPermissionsByGuard($guard);
        return response()->json($permissions);
    }
}
