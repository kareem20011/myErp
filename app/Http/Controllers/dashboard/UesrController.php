<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UesrController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,users')->only(['index', 'show']);
        $this->middleware('check.permission:create,users')->only(['create', 'store']);
        $this->middleware('check.permission:update,users')->only(['update', 'edit']);
        $this->middleware('check.permission:delete,users')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with('role')->where('tenant_id', session('tenant_id'))->orderBy('created_at', 'desc')->paginate(PAGINATE);
        return view('dashboard.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('tenant_id', session('tenant_id'))->get();
        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $status = $request->has('status') && $request->status == 'on' ? '1' : '0';
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'day' => $request->day,
            'month' => $request->month,
            'year' => $request->year,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'status' => $status,
            'created_by' => auth()->user()->id,
            'tenant_id' => session('tenant_id'),
        ]);

        if ($request->hasFile('image')) {
            $user->addMediaFromRequest('image')->toMediaCollection('images', 'employeeUploads');
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $row = User::find($id);

        $creator = User::where(['id' => $row->created_by, 'tenant_id' => session('tenant_id')])->first();
        $editor = User::where(['id' => $row->updated_by, 'tenant_id' => session('tenant_id')])->first();

        return view('dashboard.users.show', compact('row', 'creator', 'editor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $row = User::find($id);

        $roles = Role::where('tenant_id', session('tenant_id'))->get();
        return view('dashboard.users.edit', compact('row', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validated();

        $status = $request->status == 'on' ? '1' : '0';

        $validatedData['status'] = $status;

        if (!empty($validatedData['password'])) {
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

        return redirect()->route('users.show', $id)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // Find the item by ID
        $user = User::findOrFail($id);

        if ($user->tenant_id !== session('tenant_id')) {
            abort(403);
        }

        // Validate the password from the request
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the password matches the authenticated user's password
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect'])->withInput();
        }

        // remove image
        $user->clearMediaCollection('images');

        // Proceed with deletion if the password is correct
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
