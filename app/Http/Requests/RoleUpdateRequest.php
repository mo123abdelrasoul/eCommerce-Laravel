<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roleId = $this->route('role');
        // dd($roleId, $this->guard_name);
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($roleId)->where(function ($query) {
                    return $query->where('guard_name', $this->guard_name);
                })
            ],
            'guard_name' => [
                'required',
                'string',
                Rule::in(array_keys(config('auth.guards')))
            ],
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ];
    }
}
