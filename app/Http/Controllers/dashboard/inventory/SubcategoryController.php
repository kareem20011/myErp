<?php

namespace App\Http\Controllers\dashboard\inventory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,subcategories')->only(['index', 'show']);
        $this->middleware('check.permission:create,subcategories')->only(['create', 'store']);
        $this->middleware('check.permission:update,subcategories')->only(['update', 'edit']);
        $this->middleware('check.permission:delete,subcategories')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Subcategory::with('category')->where('tenant_id', session('tenant_id'))->orderBy('created_at', 'desc')->paginate(PAGINATE);
        return view('dashboard.inventory.subcategories.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainCategories = Category::where('tenant_id', session('tenant_id'))->get();
        return view('dashboard.inventory.subcategories.create', compact('mainCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required'
        ]);

        Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'created_by' => auth()->user()->id,
            'tenant_id' => session('tenant_id'),
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory created successfully.');
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
        $mainCategories = Category::where('tenant_id', session('tenant_id'))->get();
        $row = Subcategory::find($id);
        return view('dashboard.inventory.subcategories.edit', compact('row', 'mainCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required'
        ]);

        Subcategory::find($id)->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'updated_by' => auth()->user()->id
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // Find the item by ID
        $subcategory = Subcategory::findOrFail($id);

        // Validate the password from the request
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the password matches the authenticated user's password
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect'])->withInput();
        }

        // Proceed with deletion if the password is correct
        $subcategory->delete();

        return redirect()->route('subcategories.index')->with('success', 'subcategory deleted successfully');
    }
}
