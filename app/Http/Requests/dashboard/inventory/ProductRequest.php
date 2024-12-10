<?php

namespace App\Http\Requests\dashboard\inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $rules = [
            'image' => 'nullable',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'unit' => 'required|string|max:50',
            'barcode' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'barcode')->ignore($this->route('product')),
            ],
            'quantity' => 'required|integer|min:1',
            'threshold' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,onRequest',
            'subcategory_id' => 'required|integer|exists:subcategories,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'created_by' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
        ];

        // Override the quantity rule for the update (when updating)
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['quantity'] = 'nullable'; // Make quantity nullable during the update
        }

        return $rules;
    }
}
