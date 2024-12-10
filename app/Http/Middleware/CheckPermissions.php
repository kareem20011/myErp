<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission, $group = null)
    {
        $user = $request->user();

        if (session('is_admin') === true) {
            return $next($request);
        }

        if (!$user || !$user->hasPermission($permission, $group)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
