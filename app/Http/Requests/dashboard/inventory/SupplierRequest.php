<?php

namespace App\Http\Requests\dashboard\inventory;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^\+?[0-9]{10,15}$/',
            'email' => 'nullable|email|max:100',
            'address' => 'required|string',
            'status' => 'nullable',
            'notes' => 'nullable|string',
            'created_by' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date',
        ];
    }
}
