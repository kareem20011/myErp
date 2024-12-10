<?php

namespace App\Http\Controllers\dashboard\inventory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,categories')->only(['index', 'show']);
        $this->middleware('check.permission:create,categories')->only(['create', 'store']);
        $this->middleware('check.permission:update,categories')->only(['update', 'edit']);
        $this->middleware('check.permission:delete,categories')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::where('tenant_id', session('tenant_id'))->orderBy('created_at', 'desc')->paginate(PAGINATE);
        return view('dashboard.inventory.categories.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.inventory.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Category::create([
            'name' => $request->name,
            'tenant_id' => session('tenant_id'),
            'created_by' => auth()->user()->id
        ]);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
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
        $row = Category::find($id);

        return view('dashboard.inventory.categories.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['name' => 'required']);
        Category::find($id)->update([
            'name' => $request->name,
            'updated_by' => auth()->user()->id
        ]);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // Find the item by ID
        $Category = Category::findOrFail($id);

        // Validate the password from the request
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the password matches the authenticated user's password
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect'])->withInput();
        }

        // Proceed with deletion if the password is correct
        $Category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
