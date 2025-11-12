<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->where(function ($query) {
                    return $query->where('guard_name', $this->guard_name);
                })
            ],
            'guard_name' => [
                'required',
                'string',
                Rule::in(array_keys(config('auth.guards')))
            ],
        ];
    }
}
