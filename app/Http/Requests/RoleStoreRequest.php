<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->where(function ($query) {
                    return $query->where('guard_name', $this->guard_name);
                })
            ],
            'guard_name' => [
                'required',
                'string',
                Rule::in(array_keys(config('auth.guards')))
            ],
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name'
        ];
    }
}
