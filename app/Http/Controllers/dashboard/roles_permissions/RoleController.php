<?php

namespace App\Http\Controllers\dashboard\roles_permissions;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    public function __construct()
    {

        $this->middleware('check.permission:view,roles')->only(['index', 'show']);
        $this->middleware('check.permission:create,roles')->only(['create', 'store']);
        $this->middleware('check.permission:update,roles')->only(['update', 'edit']);
        $this->middleware('check.permission:delete,roles')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::where('tenant_id', session('tenant_id'))->orderBy('created_at', 'desc')->paginate(PAGINATE);
        return view('dashboard.roles_permissions.role', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('dashboard.roles_permissions.createRole', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
        ]);

        // Get the permissions from the request
        $requestedPermissions = $request->permissions;

        // Check if the authenticated user has permission to assign each requested permission
        foreach ($requestedPermissions as $permissionId) {
            $permission = Permission::find($permissionId);
            $user = User::find(auth()->user()->id);

            if (
                $permission
                && !has_permission($permission->name, $permission->group)
                && $permission->created_by !== auth()->id() // Allow if the user created this permission
            ) {
                // If the user doesn't have permission to assign this permission, throw an error
                return redirect()->route('roles.index')->with('error', 'You do not have permission to assign some of the selected permissions.');
            }
        }

        // Create the new role
        $role = Role::create([
            'name' => $request->name,
            'tenant_id' => session('tenant_id'),
        ]);

        // Assign the selected permissions to the role
        $role->permissions()->sync($requestedPermissions);

        // Return success response
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $row = Role::find($id);
        $permissions = Permission::all()->groupBy('group');
        return view('dashboard.roles_permissions.editRole', compact('row', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);

        // Get the permissions from the request
        $requestedPermissions = $request->permissions;

        // Check if the authenticated user has permission to assign each requested permission
        foreach ($requestedPermissions as $permissionId) {
            $permission = Permission::find($permissionId);
            $user = User::find(auth()->user()->id);

            if (
                $permission
                && !has_permission($permission->name, $permission->group)
                && $permission->created_by !== auth()->id() // Allow if the user created this permission
            ) {
                // If the user doesn't have permission to assign this permission, throw an error
                return redirect()->route('roles.index')->with('error', 'You do not have permission to assign some of the selected permissions.');
            }
        }

        $role = Role::findOrFail($id);

        $role->name = $request->name;
        $role->save();

        $role->permissions()->sync($requestedPermissions);

        return redirect()->route('roles.index', $id)->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        // Validate the password from the request
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the role is not the default 'admin' role
        if ($role->name == 'admin' || $role->name == 'Admin') {
            return redirect()->route('roles.index')->with('error', 'You cannot delete the default admin role.');
        }

        // Check if the provided password matches the authenticated user's password
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return redirect()->route('roles.index')->with(['error' => 'The password is incorrect']);
        }

        try {
            // Get the default 'User' role
            $defaultRole = Role::where('name', 'User')->first();

            if ($defaultRole) {
                // Update users linked to the deleted role to the default role
                User::where('role_id', $role->id)->update(['role_id' => $defaultRole->id]);
            } else {
                return redirect()->route('roles.index')->with('error', 'Default role not found. Cannot proceed with deletion.');
            }

            // Proceed to delete the role
            $role->delete();

            return redirect()->route('roles.index')->with('success', 'Role deleted successfully and users updated.');
        } catch (\Exception $e) {
            // Handle any errors during the deletion process
            return redirect()->route('roles.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
