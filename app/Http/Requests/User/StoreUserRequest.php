<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Required, string, max length of 255 characters
            'email' => 'required|email|unique:users,email|max:255', // Valid email, unique in 'users' table
            'phone' => 'required|string|min:10|max:17', // Required, string, min length of 10, max length of 15
            'password' => 'required|string|min:8|confirmed', // Password required, min 8 chars, confirmed
            'password_confirmation' => 'required_with:password|same:password', // Confirmation must match password
            'day' => 'nullable|integer|min:1|max:31', // Day must be an integer between 1 and 31
            'month' => 'nullable|integer|min:1|max:12', // Month must be an integer between 1 and 12
            'year' => 'nullable|integer|min:1900|max:' . (date('Y')), // Year must be between 1900 and current year
            'role_id' => 'nullable|integer', // Role id must be an integer
            'image' => 'nullable',
            'status' => 'string', // Status must be either 'active' or 'inactive'
        ];
    }
}
