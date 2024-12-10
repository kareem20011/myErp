<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // If there's no parameter in the route, skip the tenant check (or handle general access control)
        if (session('is_admin')) {
            return $next($request);
        }

        // Get the parameter name dynamically from the route
        $parameterName = $this->getParameterName($request);

        // If there's no parameter in the route, skip the tenant check (or handle general access control)
        if (!$parameterName) {
            return $next($request);
        }

        // Determine the model dynamically based on the parameter
        $model = $this->getModelForParameter($parameterName);

        // If no model is found, abort with a 404 error
        if (!$model) {
            abort(404, 'Model not found for parameter ' . $parameterName);
        }

        // Retrieve the resource (e.g., category, product, etc.) dynamically using the model and parameter value
        $data = $model::find($request->route($parameterName));

        // If the data does not exist, abort with a 404 error
        if (!$data) {
            abort(404, 'Resource not found');
        }

        // Check if the tenant_id of the resource matches the session tenant_id
        // and ensure the user is either an admin or accessing their own data
        if ($data->tenant_id !== session('tenant_id') && !session('is_admin')) {
            abort(403, 'You do not have permission to access this data');
        }

        // Allow the request to proceed if all checks pass
        return $next($request);
    }

    // Get the parameter name dynamically based on route parameters
    private function getParameterName(Request $request)
    {
        // Define possible parameter names that could be in the route
        $parameterNames = [
            'id',
            'category',
            'product',
            'subcategory',
            'supplier',
            'permission',
            'role',
            'user',
        ];

        // Check if any of the expected parameter names exist in the route
        foreach ($parameterNames as $param) {
            if ($request->route($param)) {
                return $param; // Return the matching parameter name
            }
        }

        // Return null if no parameter is found
        return null;
    }

    private function getModelForParameter($parameterName)
    {
        // Map the parameter names to the respective models
        $modelMap = [
            'category' => \App\Models\Category::class,
            'product' => \App\Models\Product::class,
            'subcategory' => \App\Models\Subcategory::class,
            'supplier' => \App\Models\Supplier::class,
            'permission' => \App\Models\Permission::class,
            'role' => \App\Models\Role::class,
            'user' => \App\Models\User::class,
            // Add more mappings as needed for other models
        ];

        // Return the model class for the parameter, or null if not found
        return $modelMap[$parameterName] ?? null;
    }
}
