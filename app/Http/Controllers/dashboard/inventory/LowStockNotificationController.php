<?php

namespace App\Http\Controllers\dashboard\inventory;

use App\Http\Controllers\Controller;
use App\Models\LowStockNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LowStockNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,LowStockNotification')->only(['index']);
        $this->middleware('check.permission:delete,LowStockNotification')->only(['destroy']);
    }

    public function index()
    {
        $data = LowStockNotification::with('product', 'user')->where('tenant_id', session('tenant_id'))->orderBy('created_at', 'desc')->paginate(PAGINATE);
        return view('dashboard.inventory.low_stock_notifications.index', compact('data'));
    }

    public function destroy(Request $request, $id)
    {
        // Find the item by ID
        $LowStockNotifications = LowStockNotification::findOrFail($id);

        // Validate the password from the request
        $validated = $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the password matches the authenticated user's password
        if (!Hash::check($validated['password'], auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect'])->withInput();
        }

        // Proceed with deletion if the password is correct
        $LowStockNotifications->delete();

        return redirect()->route('low.stock.index')->with('success', 'stock notification deleted successfully');
    }
}
