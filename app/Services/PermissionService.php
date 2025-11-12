<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function list($search = null, $perPage = 10)
    {
        return Permission::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        return Permission::create($data);
    }

    public function update(Permission $permission, array $data)
    {
        return $permission->update($data);
    }

    public function delete(Permission $permission)
    {
        return $permission->delete();
    }

    public function find($id)
    {
        return Permission::findOrFail($id);
    }

    public function getGuards()
    {
        return array_keys(config('auth.guards'));
    }
}
