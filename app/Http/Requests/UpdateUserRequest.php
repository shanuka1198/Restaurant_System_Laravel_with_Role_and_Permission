<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id'); // URL එකේ user ID එක ගන්නවා

        return [
            'name' => 'sometimes|string|max:255',
            // 'email' => [
            //     'sometimes',
            //     'email',
            //     Rule::unique('users', 'email')->ignore($userId)
            // ],
            'password' => 'sometimes|string|min:6',

            // Roles validation
            'roles' => 'sometimes|array',
            'roles.*' => ['integer', Rule::exists(Role::class, 'id')],

            // Permissions validation
            'permissions' => 'sometimes|array',
            'permissions.*' => ['integer', Rule::exists(Permission::class, 'id')],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'name.string' => 'User name must be a string.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already taken.',
            'password.min' => 'Password must be at least 6 characters.',
            'roles.array' => 'Roles must be an array.',
            'roles.*.exists' => 'One or more roles are invalid.',
            'permissions.array' => 'Permissions must be an array.',
            'permissions.*.exists' => 'One or more permissions are invalid.',
        ];
    }
}