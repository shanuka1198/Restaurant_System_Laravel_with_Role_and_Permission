<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class StoreUserRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',

            // Roles must be array of existing role IDs
            'roles'       => 'sometimes|array',
            'roles.*'     => ['integer', Rule::exists(Role::class, 'id')],

            // Permissions must be array of existing permission IDs
            'permissions' => 'sometimes|array',
            'permissions.*' => ['integer', Rule::exists(Permission::class, 'id')],
        ];
    }

    /**
     * Custom error messages (optional)
     */
    public function messages(): array
    {
        return [
            'name.required' => 'User name is required.',
            'email.required' => 'Email is required.',
            'email.unique'   => 'This email is already taken.',
            'password.required' => 'Password is required.',
            'roles.array'      => 'Roles must be an array.',
            'roles.*.exists'   => 'One or more roles are invalid.',
            'permissions.array' => 'Permissions must be an array.',
            'permissions.*.exists' => 'One or more permissions are invalid.',
        ];
    }
}
