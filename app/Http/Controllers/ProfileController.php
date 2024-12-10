<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = User::with('role')->find(auth()->user()->id);
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = User::with('role')->find(auth()->user()->id);
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Name is required, string, and max length of 255 characters
            'email' => 'required|email|unique:users,email,' . $user->id . '|max:255', // Email is required and unique, except for the current user's email
            'phone' => 'required|string|min:10|max:17', // Phone is required, string, min length of 10, max length of 17
            'oldPassword' => 'nullable|string|min:8', // Password is optional for update, but if provided, it must be confirmed
            'password' => 'nullable|string|min:8|confirmed', // Password is optional for update, but if provided, it must be confirmed
            'password_confirmation' => 'nullable|same:password', // Password confirmation is required only if password is provided
            'day' => 'nullable|integer|min:1|max:31', // Day is optional, must be an integer between 1 and 31
            'month' => 'nullable|integer|min:1|max:12', // Month is optional, must be an integer between 1 and 12
            'year' => 'nullable|integer|min:1900|max:' . date('Y'), // Year is optional, must be an integer between 1900 and current year
            'role_id' => 'nullable|integer', // Role id must be an integer
            'image' => 'nullable',
            'status' => 'nullable|string', // Status is optional, but if provided, it must be either 'active' or 'inactive'
        ]);

        if (!empty($validatedData['password'])) {
            if (!Hash::check($validatedData['oldPassword'], auth()->user()->password)) {
                return back()->withErrors(['oldPassword' => 'The password is incorrect'])->withInput();
            }
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $validatedData['updated_by'] = auth()->id();

        $user->update($validatedData);

        if ($request->hasFile('image')) {
            $user->clearMediaCollection('images');
            $user->addMediaFromRequest('image')->toMediaCollection('images', 'employeeUploads');
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}
