<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleService
{
    public function list($search = null, $perPage = 10)
    {
        return Role::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getGuards()
    {
        return array_keys(config('auth.guards'));
    }

    public function getPermissionsByGuard($guard)
    {
        return Permission::where('guard_name', $guard)->get();
    }

    public function find($id)
    {
        return Role::findOrFail($id);
    }

    public function create(array $data)
    {
        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => $data['guard_name']
        ]);
        $role->syncPermissions($data['permissions']);
        return $role;
    }

    public function update($roleId, array $data)
    {
        $role = Role::findOrFail($roleId);

        $permissions = Permission::whereIn('id', $data['permissions'])
            ->where('guard_name', $data['guard_name'])
            ->pluck('id')
            ->toArray();

        $role->update([
            'name' => $data['name'],
            'guard_name' => $data['guard_name'],
        ]);

        $role->syncPermissions($permissions);

        return $role;
    }


    public function delete(Role $role)
    {
        return $role->delete();
    }
}
