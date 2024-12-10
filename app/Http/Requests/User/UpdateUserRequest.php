<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => 'required|string|max:255', // Name is required, string, and max length of 255 characters
            'email' => 'required|email|unique:users,email,' . $userId . '|max:255', // Email is required and unique, except for the current user's email
            'phone' => 'required|string|min:10|max:17', // Phone is required, string, min length of 10, max length of 17
            'password' => 'nullable|string|min:8|confirmed', // Password is optional for update, but if provided, it must be confirmed
            'password_confirmation' => 'nullable|same:password', // Password confirmation is required only if password is provided
            'day' => 'nullable|integer|min:1|max:31', // Day is optional, must be an integer between 1 and 31
            'month' => 'nullable|integer|min:1|max:12', // Month is optional, must be an integer between 1 and 12
            'year' => 'nullable|integer|min:1900|max:' . date('Y'), // Year is optional, must be an integer between 1900 and current year
            'role_id' => 'nullable|integer', // Role id must be an integer
            'image' => 'nullable',
            'status' => 'nullable|string', // Status is optional, but if provided, it must be either 'active' or 'inactive'
        ];
    }
}
