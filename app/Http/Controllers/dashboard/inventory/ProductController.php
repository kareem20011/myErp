<?php

namespace App\Http\Controllers\dashboard\inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\inventory\ProductRequest;
use App\Models\LowStockNotification;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,products')->only(['index', 'show']);
        $this->middleware('check.permission:create,products')->only(['create', 'store']);
        $this->middleware('check.permission:update,products')->only(['update', 'edit']);
        $this->middleware('check.permission:delete,products')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with('supplier', 'subcategory')->where('tenant_id', session('tenant_id'))->orderBy('created_at', 'desc')->paginate(PAGINATE);
        return view('dashboard.inventory.products.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategories = Subcategory::where('tenant_id', session('tenant_id'))->get();
        $suppliers = Supplier::where(['status' => 'active', 'tenant_id' => session('tenant_id')])->get();
        return view('dashboard.inventory.products.create', compact('subcategories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->user()->id;
        $validated['tenant_id'] = session('tenant_id');
        $product = Product::create($validated);
        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('images', 'productUploads');
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $row = Product::with('supplier', 'subcategory')->find($id);
        $row['created_by'] = User::find($row->created_by);
        $row['updated_by'] = User::find($row->updated_by);
        return view('dashboard.inventory.products.show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $row = Product::with('supplier', 'subcategory')->find($id);
        $subcategories = Subcategory::where('tenant_id', session('tenant_id'))->get();
        $suppliers = Supplier::where(['status' => 'active', 'tenant_id' => session('tenant_id')])->get();
        return view('dashboard.inventory.products.edit', compact('row', 'subcategories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $validated = $request->validated();
        $validated['updated_by'] = auth()->user()->id;
        $product = Product::find($id);
        if ($request->hasFile('image')) {
            $product->clearMediaCollection('images');
            $product->addMediaFromRequest('image')->toMediaCollection('images', 'productUploads');
        }
        $product->update($validated);
        return redirect()->route('products.show', $id)->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // Find the item by ID
        $product = Product::findOrFail($id);

        // Validate the password from the request
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the password matches the authenticated user's password
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect'])->withInput();
        }

        // remove image
        $product->clearMediaCollection('images');

        // Proceed with deletion if the password is correct
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function search(Request $request)
    {

        $query = $request->input('query');

        $data = Product::where('tenant_id', session('tenant_id'))
            ->where(function ($subQuery) use ($query) {
                $subQuery->where('name', 'like', '%' . $query . '%')
                    ->orWhere('barcode', 'like', '%' . $query . '%');
            })
            ->paginate(10);
        return view('dashboard.inventory.products.index', compact('data', 'query'));
    }
}
