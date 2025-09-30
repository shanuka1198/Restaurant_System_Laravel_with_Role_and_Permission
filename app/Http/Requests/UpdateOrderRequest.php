<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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

            'customer_id' => 'required|exists:customers,id',
            'items'       => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.qty'     => 'required|integer|min:1',
            'status'      => 'required|string|in:pending,completed,cancelled',

        ];
    }
 public function messages(): array
    {
        return [
            'customer_id.required' => 'Customer is required.',
            'customer_id.exists'   => 'Selected customer does not exist.',
            'items.required'       => 'At least one item is required.',
            'items.array'          => 'Items must be an array.',
            'items.*.item_id.required' => 'Item ID is required.',
            'items.*.item_id.exists'   => 'Selected item does not exist.',
            'items.*.qty.required'     => 'Quantity is required for each item.',
            'items.*.qty.integer'      => 'Quantity must be an integer.',
            'items.*.qty.min'          => 'Quantity must be at least 1.',
            'status.required'          => 'Order status is required.',
            'status.in'                => 'Status must be pending, completed, or cancelled.',
        ];
    }

}
