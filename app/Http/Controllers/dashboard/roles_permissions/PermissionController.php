<?php

namespace App\Http\Controllers\dashboard\roles_permissions;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,permissions')->only(['index', 'show']);
        $this->middleware('check.permission:create,permissions')->only(['create', 'store']);
        $this->middleware('check.permission:update,permissions')->only(['update', 'edit']);
        $this->middleware('check.permission:delete,permissions')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissionGroups = Permission::all()->groupBy('group');

        // Sort the groups by group name
        $permissionGroups = $permissionGroups->sortBy(function ($group, $key) {
            return $key; // Sort by the group name (key of the group)
        });

        return view('dashboard.roles_permissions.permissions', compact('permissionGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.roles_permissions.createPermissions');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define the valid ENUM values
        $validPermissions = ['view', 'create', 'update', 'delete'];

        $request->validate([
            'name' => 'required|array',
            'name.*' => 'required|string|in:' . implode(',', $validPermissions), // Each value must be one of the ENUMs
            'group' => 'required|string',
        ]);

        // check if permission exists
        $check = Permission::where(['name' => $request->name, 'group' => $request->group])->get();
        if (count($check) > 0) {
            return back()->withErrors(['error' => 'This permission already exists.'])->withInput();
        }

        // Loop through the selected permissions and store them
        foreach ($request->name as $permissionName) {
            // Create the permission if it doesn't exist
            Permission::create([
                'name' => $permissionName,
                'group' => $request->group,
                'created_by' => auth()->user()->id,
            ]);
        }

        return redirect()->route('permissions.index')->with('success', 'Role created successfully.');
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
    public function edit(string $group)
    {
        $permissionGroup = Permission::where('group', $group)->get()->groupBy('group');
        return view('dashboard.roles_permissions.editPermissions', compact('permissionGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'name'  => 'required|array|min:1', // Ensure 'name' is an array with at least one element
            'name.*' => 'string|in:view,create,update,delete', // Ensure each name is a valid permission
            'group' => 'required|string', // Ensure 'group' is provided as a string
        ]);

        // Get the current permissions for the specified group
        $currentPermissions = Permission::where('group', $validated['group'])->pluck('name')->toArray();

        // Calculate permissions to delete (present in the database but not in the new input)
        $permissionsToDelete = array_diff($currentPermissions, $validated['name']);

        // Calculate permissions to add (present in the new input but not in the database)
        $permissionsToAdd = array_diff($validated['name'], $currentPermissions);

        // Delete the permissions that are no longer needed
        Permission::where('group', $validated['group'])
            ->whereIn('name', $permissionsToDelete)
            ->delete();

        // Insert the new permissions into the database
        $permissions = collect($permissionsToAdd)->map(function ($permission) use ($validated) {
            return ['group' => $validated['group'], 'name' => $permission];
        });

        Permission::insert($permissions->toArray());

        return redirect()->route('permissions.index')->with('success', 'Permissions have been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $group)
    {
        $permissions = Permission::where('group', $group)->get();

        // Validate the password from the request
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the password matches the authenticated user's password
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect'])->withInput();
        }

        // Proceed with deletion if the password is correct
        foreach ($permissions as $permission) {
            $permission->delete();
        }

        return redirect()->route('permissions.index')->with('success', 'Permissions group deleted successfully');
    }
}
