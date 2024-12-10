<?php

namespace App\Http\Controllers\dashboard\inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\inventory\InventoryLogRequest;
use App\Models\InventoryLog;
use App\Models\LowStockNotification;
use App\Models\Product;

class InventoryLogController extends Controller
{
    public function index()
    {
        $data = InventoryLog::with('product', 'user')->where('tenant_id', session('tenant_id'))->orderBy('created_at', 'desc')->paginate(PAGINATE);
        return view('dashboard.inventory.logs.index', compact('data'));
    }

    public function edit($id)
    {
        $row = Product::find($id)->only('id', 'quantity', 'name');
        return view('dashboard.inventory.logs.edit', compact('row'));
    }

    public function update(InventoryLogRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $newQuantity = $request->quantity;
        $oldQuantity = $product->quantity;
        $quantity_changed = $newQuantity - $oldQuantity;
        $change_type = $quantity_changed > 0 ? 'add' : 'subtract';

        if ($newQuantity == $oldQuantity) {
            return back()->withErrors(['quantity' => 'No change found!']);
        }

        InventoryLog::create([
            'product_id' => $id,
            'change_type' => $change_type,
            'quantity_changed' => $quantity_changed,
            'reason' => $request->reason,
            'tenant_id' => session('tenant_id'),
            'created_by' => auth()->user()->id,
        ]);

        $product->quantity = $newQuantity;
        $product->save();

        $lowStockNotification = LowStockNotification::where(['product_id' => $product->id, 'tenant_id' => session('tenant_id')])->first();


        if ($newQuantity <= $product->threshold) {
            // إذا كانت الكمية أقل من أو تساوي threshold، قم بتحديد حالة الإشعار كـ "غير محلول"
            if (!$lowStockNotification) {
                LowStockNotification::create([
                    'product_id' => $product->id,
                    'status' => 'unresolved',
                    'tenant_id' => session('tenant_id'),
                ]);
            } elseif ($lowStockNotification->status != 'unresolved') {
                $lowStockNotification->status = 'unresolved';
                $lowStockNotification->save();
            }
        } else {
            // إذا كانت الكمية أكبر من threshold، قم بتحديد حالة الإشعار كـ "محلول"
            if ($lowStockNotification && $lowStockNotification->status != 'resolved') {
                $lowStockNotification->status = 'resolved';
                $lowStockNotification->resolved_at = now();
                $lowStockNotification->resolved_by = auth()->user()->id;
                $lowStockNotification->save();
            }
        }

        return redirect()->route('products.show', $id)->with('success', 'Quantity updated successfully.');
    }
}
