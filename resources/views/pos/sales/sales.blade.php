@extends('layouts.pos')
@section('pos.content')
@include('pos.sales.salesModales')

<div class="container-fluid mt-5">
    <h1 class="text-center">New order</h1>

    <div class="row mt-3">
        <div class="col-12 col-md-8">
            <div class="card">
                <h5 class="card-title px-4 py-3 text-white" style="background-color: #333;">Choose Product & Product Details</h5>
                <div class="card-body">
                    <div class="form-group position-relative">
                        <label for="product" class="col-form-label">Search by barcode or product name</label>
                        <input type="search" class="form-control" placeholder="search..." id="productSearch">
                        <ul class="dropdown-menu w-100" id="product-list" style="display: none; max-height: 200px; overflow-y: auto;"></ul>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>
                            <th scope="col">description</th>
                            <th scope="col">price</th>
                            <th scope="col">barcode</th>
                            <th scope="col">quantity</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="productData">
                        @if(count($products) <= 0)
                            <tr>
                            <td colspan="7" class="text-center">No products added yet</td>
                            </tr>
                            @endif
                            @foreach($products as $index => $product)
                            <tr class="data">
                                <td scope="col">{{ $index + 1 }}</td>
                                <td scope="col">{{ $product['product_name'] }}</td>
                                <td scope="col">{{ $product['product_description'] }}</td>
                                <td scope="col">{{ $product['product_price'] }}</td>
                                <td scope="col">{{ $product['product_barcode'] }}</td>
                                <td scope="col"><input type="number" min="1" value="{{ $product['quantity'] }}" data-id="{{ $product['product_id'] }}" class="form-control quantity-input sales"></td>
                                <td><button data-id="{{ $product['product_id'] }}" class="delete-item btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card">
                <h5 class="card-title px-4 py-3 text-white" style="background-color: #777;">payments</h5>
                <div class="card-body">
                    <!-- button create customer modal -->
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#customer">New customer</button>
                    <div>
                        <label for="customer" class="col-form-label">Search by customer name</label>
                    </div>
                    <div style="position: relative;">
                        <input name="email" type="search" class="form-control" placeholder="search..." id="customerSearch">
                        <ul class="dropdown-menu w-100" id="customer-list" style="display: none; max-height: 200px; overflow-y: auto;"></ul>
                    </div>

                    <div>
                        <label for="payment-method"></label>
                        <select id="payment-method" class="form-control">
                            <option value="cash">Cash</option>
                            <option value="visa">Visa</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer">
                    <p>Subtotal: <span id="total-amount">0.00</span></p>
                    <button id="check-out" class="btn btn-info w-100">Check out</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pos.sales.salesScript')
@endsection