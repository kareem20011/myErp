<?php

namespace App\Http\Requests\dashboard\inventory;

use Illuminate\Foundation\Http\FormRequest;

class InventoryLogRequest extends FormRequest
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
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'created_by' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'The product ID is required.',
            'product_id.exists' => 'The specified product does not exist.',
            'change_type.required' => 'The change type is required.',
            'change_type.in' => 'The change type must be either "add" or "subtract".',
            'quantity_changed.required' => 'The quantity change is required.',
            'quantity_changed.integer' => 'The quantity must be a valid integer.',
            'quantity_changed.min' => 'The quantity must be at least 1.',
            'reason.required' => 'A reason for the change is required.',
            'reason.max' => 'The reason must not exceed 255 characters.',
            'created_by.exists' => 'The creator must be a valid user ID.',
        ];
    }
}
