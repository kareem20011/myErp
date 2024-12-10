<?php

namespace App\Http\Controllers\pos;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,pos');
    }


    public function index()
    {
        $products = Session::get('cart', []);
        return view('pos.sales.sales', compact('products'));
    }




    public function searchProduct(Request $request)
    {
        $product = $request->product;
        $data = Product::where(['tenant_id' => session('tenant_id'), 'status' => 'active'])
            ->where(function ($query) use ($product) {
                $query->where('name', 'LIKE', "%$product%")
                    ->orWhere('barcode', 'LIKE', "%$product%");
            })
            ->get();
        return response()->json($data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'barcode' => $item->barcode,
                'price' => $item->price,
            ];
        }));
    }




    public function addToSession(Request $request)
    {
        $productId = $request->productId;
        $productData = Product::find($productId);

        $cart = session('cart', []);

        // if product exists update quantity
        $productExists = false;
        foreach ($cart as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] += 1;
                $productExists = true;
                break;
            }
        }

        // if not exists add new
        if (!$productExists) {
            $cart[] = [
                'product_id' => $productData->id,
                'product_name' => $productData->name,
                'product_description' => $productData->description,
                'product_price' => $productData->price,
                'product_barcode' => $productData->barcode,
                'quantity' => 1,
            ];
        }

        session(['cart' => $cart]);

        return response()->json(array_values($cart));
    }





    public function removeItemSession(Request $request)
    {
        $products = Session::get('cart', []);
        $products = array_filter($products, function ($product) use ($request) {
            return $product['product_id'] !== (int) $request->productId;
        });
        Session::put('cart', $products);
        $products = Session::get('cart', []);
        return response()->json(array_values($products));
    }




    public function updateQuantity(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;

        if (session()->has('cart')) {
            $cart = session('cart');

            foreach ($cart as $index => $item) {
                if (isset($item['product_id']) && $item['product_id'] == $productId) {
                    $cart[$index]['quantity'] = $quantity;
                    break;
                }
            }

            session(['cart' => $cart]);
        }

        return response()->json(array_values($cart));
    }
}
