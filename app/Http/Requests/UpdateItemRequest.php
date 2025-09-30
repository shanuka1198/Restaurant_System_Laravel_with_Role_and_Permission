<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            'item_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:item_categories,id',

        ];
    }
    public function messages()
    {
        return [
             'item_name.required'   => 'Item name is required.',
            'price.required'       => 'Price is required.',
            'price.numeric'        => 'Price must be a number.',
            'qty.required'         => 'Quantity is required.',
            'qty.integer'          => 'Quantity must be an integer.',
            'category_id.required' => 'Category is required.',
            'category_id.exists'   => 'The selected category does not exist.',
        ];
    }

}