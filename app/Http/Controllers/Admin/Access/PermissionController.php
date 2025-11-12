<?php

namespace App\Http\Controllers\Admin\Access;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $permissions = $this->service->list($request->get('search'));
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $guards = $this->service->getGuards();
        return view('admin.permissions.create', compact('guards'));
    }

    public function store(PermissionStoreRequest $request)
    {
        $this->service->create($request->validated());
        return back()->with('success', 'Permission added successfully!');
    }

    public function edit($lang, $id)
    {
        $permission = $this->service->find($id);
        $guards = $this->service->getGuards();
        return view('admin.permissions.edit', compact('permission', 'guards'));
    }

    public function update(PermissionUpdateRequest $request, $lang, $id)
    {
        $permission = $this->service->find($id);
        $this->service->update($permission, $request->validated());
        return back()->with('success', 'Permission updated successfully!');
    }

    public function destroy($lang, $id)
    {
        $permission = $this->service->find($id);
        try {
            $this->service->delete($permission);
            return back()->with('success', 'Permission deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the permission. Please try again.');
        }
    }
}
