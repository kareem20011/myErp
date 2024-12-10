<?php

use App\Models\User;
use Illuminate\Support\Facades\Session;

if (!function_exists('has_permission')) {
    function has_permission($permission, $group = null)
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        $user = User::find(auth()->user()->id);

        if (Session::get('is_admin') === true) {
            return true;
        }

        return $user && $user->hasPermission($permission, $group);
    }
}
