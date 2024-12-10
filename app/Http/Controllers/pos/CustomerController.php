<?php

namespace App\Http\Controllers\pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:view,pos');
    }


    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['tenant_id'] = session('tenant_id');
        Customer::create($data);
        return back()->with('statuse', 'Customer created successfully.');
    }

    public function search(Request $request)
    {
        $customer = $request->customer;
        $data = Customer::where('tenant_id', session('tenant_id'))
            ->where(function ($query) use ($customer) {
                $query->where('email', 'LIKE', "%$customer%")
                    ->orWhere('phone', 'LIKE', "%$customer%");
            })
            ->get();

        return response()->json($data->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
            ];
        }));
    }
}
