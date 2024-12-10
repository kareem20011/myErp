<?php

namespace App\Http\Controllers\pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\InventoryLog;
use App\Models\LowStockNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,pos');
    }

    public function index()
    {
        $orders = Order::with('customer')
            ->where(['status' => 'completed', 'tenant_id' => session('tenant_id')])
            ->orderBy('order_date', 'desc')->get();
        return view('pos.orders.index', compact('orders'));
    }



    public function show($orderId)
    {
        $order = Order::with('customer', 'orderItems.product')->find($orderId);
        return view('pos.orders.orderItems', compact('order'));
    }




    public function checkout(Request $request)
    {
        $cart = session('cart', []);

        // check if cart is empty
        if (empty($cart)) {
            return response()->json(['error' => 'Your cart is empty.'], 400);
        }

        // Validate stock for all products
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) {
                return response()->json(['error' => "Product ID: {$item['product_id']} not found."], 400);
            }

            if ($product->quantity < $item['quantity']) {
                return response()->json(['error' => "Insufficient stock for product ID: {$item['product_id']}."], 400);
            }
        }


        // Get data
        $paymentMethod = $request->input('payment_method');
        $totalAmount = $request->input('total_amount');
        $customerEmail = $request->input('customer_email')
            ? Customer::where('email', $request->input('customer_email'))->first()->id
            : null;



        // Create order
        $order = new Order();
        $order->customer_id = $customerEmail;
        $order->total_amount = $totalAmount;
        $order->payment_method = $paymentMethod;
        $order->tenant_id = session('tenant_id');
        $order->save();

        // Process cart items
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);

            // Deduct quantity from stock
            $product->quantity -= $item['quantity'];
            $product->save();

            // Check if stock is below threshold
            if ($product->quantity <= $product->threshold) {
                LowStockNotification::create([
                    'product_id' => $product->id,
                    'status' => 'unresolved',
                    'tenant_id' => session('tenant_id'),
                ]);
            }

            // Log inventory transaction
            InventoryLog::create([
                'product_id' => $product->id,
                'quantity_changed' => -$item['quantity'],
                'change_type' => 'sale',
                'tenant_id' => session('tenant_id'),
                'created_by' => auth()->id(),
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $item['product_price'],
                'total_price' => $item['product_price'] * $item['quantity'],
                'tenant_id' => session('tenant_id'),
            ]);
        }

        // Clear cart
        session()->forget('cart');
        return response()->json(['message' => 'Order placed successfully!']);
    }




    public function get_return($id)
    {
        $order = Order::with('customer', 'orderItems')->find($id);
        return view('pos.orders.return', compact('order'));
    }

    public function return(Request $request, $id)
    {

        $order = Order::with('orderItems')->find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        // Check if order is already refunded
        if ($order->status === 'refunded') {
            return response()->json(['error' => 'Order is already refunded.'], 400);
        }
        
        // return $order;

        foreach ($order->orderItems as $item) {
            $product = Product::find($item->product_id);

            InventoryLog::create([
                'product_id' => $product->id,
                'change_type' => 'add',
                'quantity_changed' => $item->quantity,
                'reason' => $request->reason,
                'created_by' => auth()->user()->id,
                'tenant_id' => session('tenant_id'),
            ]);

            $product->quantity += $item->quantity;
            $product->save();
        }

        $order->return_reason = $request->reason ?: null;
        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('pos.orders')->with('success', 'Order returned successfully');

    }


    public function filter(Request $request)
    {
        $status = $request->key;
        $orders = Order::with('customer')
            ->where(['status' => $status, 'tenant_id' => session('tenant_id')])
            ->orderBy('order_date', 'desc')->get();
        return response()->json($orders);
    }
}
