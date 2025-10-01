<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
         $roleId = $this->route('role');
        return [
             'name' => 'required|string|max:100|unique:roles,name,' . $roleId,
            'guard_name' => 'required|string|in:web,api',
            'permissions'   => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id'
        ];
    }

     public function messages(): array
    {
        return [
            'name.required' => 'Role name is required.',
            'name.unique'   => 'This role name already exists.',
            'permissions.required' => 'Please select at least one permission.',
            'permissions.*.exists' => 'Invalid permission ID.',
        ];
    }
}