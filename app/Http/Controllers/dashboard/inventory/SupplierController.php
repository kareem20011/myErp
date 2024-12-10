<?php

namespace App\Http\Controllers\dashboard\inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\inventory\SupplierRequest;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,suppliers')->only(['index', 'show']);
        $this->middleware('check.permission:create,suppliers')->only(['create', 'store']);
        $this->middleware('check.permission:update,suppliers')->only(['update', 'edit']);
        $this->middleware('check.permission:delete,suppliers')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Supplier::where('tenant_id', session('tenant_id'))->orderBy('created_at', 'desc')->paginate(PAGINATE);
        return view('dashboard.inventory.suppliers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.inventory.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = $request->status == 'on' ? 'active' : 'inactive';
        $validated['created_by'] = auth()->user()->id;
        $validated['tenant_id'] = session('tenant_id');
        Supplier::create($validated);
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $row = Supplier::with('products')->find($id);
        $row['created_by'] = User::find($row->created_by);
        $row['updated_by'] = User::find($row->updated_by);
        return view('dashboard.inventory.suppliers.show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $row = Supplier::find($id);
        return view('dashboard.inventory.suppliers.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, string $id)
    {
        $validated = $request->validated();
        $validated['status'] = $request->status == 'on' ? 'active' : 'inactive';
        $validated['updated_by'] = auth()->user()->id;
        Supplier::find($id)->update($validated);
        return redirect()->route('suppliers.show', $id)->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // Find the item by ID
        $supplier = Supplier::findOrFail($id);

        // Validate the password from the request
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the password matches the authenticated user's password
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect'])->withInput();
        }

        // Proceed with deletion if the password is correct
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully');
    }
}
