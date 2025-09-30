<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
             'name'    => 'required|string|max:255',
            // 'email'   => 'required|email|unique:customers,email',
            'phone'   => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Customer name is required.',
            'name.string'       => 'Customer name must be a valid string.',
            'name.max'          => 'Customer name may not be greater than 255 characters.',

            'email.required'    => 'Email address is required.',
            'email.email'       => 'Please provide a valid email address.',
            'email.unique'      => 'This email is already registered.',

            'phone.required'    => 'Phone number is required.',
            'phone.string'      => 'Phone number must be a valid string.',
            'phone.max'         => 'Phone number may not be longer than 15 characters.',

            'address.string'    => 'Address must be a valid string.',
            'address.max'       => 'Address may not be longer than 255 characters.',

            'user_id.required'  => 'User ID is required.',
            'user_id.exists'    => 'Selected User ID does not exist in the system.'
        ];
    }


}
