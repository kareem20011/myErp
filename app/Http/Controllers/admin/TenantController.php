<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LoginLogs;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class TenantController extends Controller
{
    public function index()
    {
        session(['tenant_id' => null]);
        Session::forget('cart');
        LoginLogs::where('user_id', Auth::id())
            ->whereNull('logout_time') // Ensure we're updating the latest login session
            ->update(['logout_time' => now()]);
        $data = Tenant::paginate(PAGINATE);
        return view('admin.tenants.index', compact('data'));
    }

    public function show($id)
    {
        session(['tenant_id' => $id]);
        LoginLogs::create([
            'user_id' => Auth::id(),
            'tenant_id' => session('tenant_id'),
            'ip_address' => request()->ip(),
            'device' => request()->userAgent(),
            'login_time' => now(),
        ]);

        $row = Tenant::find($id);

        return view('admin.tenants.show', compact('row'));
    }

    public function create()
    {
        return view('admin.tenants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email|unique:tenants,email',
            'address' => 'required|string|max:255',
            'status' => 'nullable',
        ]);
        $validated['status'] = $request->status ? 'active' : 'inactive';
        $tenant = Tenant::create($validated);
        if ($request->hasFile('image')) {
            $tenant->addMediaFromRequest('image')->toMediaCollection('images', 'tenantUploads');
        }
        return redirect()->route('admin.tenants.index')->with('success', 'Tenant created successfully');
    }

    public function edit($id)
    {
        $row = Tenant::find($id);
        return view('admin.tenants.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email|unique:tenants,email,' . $id,
            'address' => 'required|string|max:255',
            'status' => 'nullable',
        ]);

        $tenant = Tenant::find($id);

        if ($request->hasFile('image')) {
            $tenant->clearMediaCollection('images');
            $tenant->addMediaFromRequest('image')->toMediaCollection('images', 'tenantUploads');
        }

        $validated['status'] = $request->status ? 'active' : 'inactive';

        $tenant->update($validated);

        return redirect()->route('admin.tenants.show', $tenant->id)->with('success', 'Tenant updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        // Find the item by ID
        $tenant = Tenant::findOrFail($id);

        // Validate the password from the request
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the password matches the authenticated user's password
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect'])->withInput();
        }

        // remove image
        $tenant->clearMediaCollection('images');

        // Proceed with deletion if the password is correct
        $tenant->delete();

        session(['tenant_id' => null]);

        return redirect()->route('admin.tenants.index')->with('success', 'tenant deleted successfully');
    }
}
