@extends('layouts.pos')
@section('pos.content')
@if (Session::has('success'))
<script>
    $(document).ready(function() {
        toastr.success("{{ Session::get('success') }}");
    });
</script>
@endif
<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-header">
            <h1 class="text-center">orders data</h1>
            <div class="d-flex justify-content-between">
                <div class="row g-3 align-items-end">
                    <div class="col-auto">
                        <label for="status">Status:</label>
                    </div>
                    <div class="col-auto">
                        <select id="status" class="form-control" style="width: 150px;">
                            <option value="completed" selected>completed</option>
                            <option value="cancelled">cancelled</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">order id</th>
                            <th scope="col">customer</th>
                            <th scope="col">order date</th>
                            <th scope="col">total amount</th>
                            <th scope="col">offer</th>
                            <th scope="col">payment method</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="content">
                        @if(count($orders) < 1)
                            <tr>
                            <td colspan="6">
                                No orders yet.
                            </td>
                            </tr>
                            @endif
                            @foreach($orders as $index => $order)
                            <tr class="order-item" data-order-id="{{ $order->id }}" style="cursor: pointer;">
                                <th scope="row">{{ $index + 1 }}</th>
                                <td scope="row">{{ $order->id }}</td>
                                <td>
                                    @if( $order->customer )
                                    @if( $order->customer->email )
                                    {{ $order->customer->email }}
                                    @elseif( $order->customer->phone )
                                    {{ $order->customer->phone }}
                                    @else
                                    {{ $order->customer->name }}
                                    @endif
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    {{ date('h:i:s A', strtotime($order->order_date)) }}
                                    <br>
                                    {{ date('Y-m-d', strtotime($order->order_date)) }}
                                </td>
                                <td>{{ $order->total_amount }} EGP</td>
                                <td>
                                    {{ $order->offer ?: '0' }} %
                                </td>
                                <td>{{ $order->payment_method }}</td>
                                <td>{{ $order->status }}</td>
                                <td>
                                    @if($order->status != 'cancelled')
                                    <a href="{{ route('pos.orders.get_return', $order->id) }}" class="btn btn-outline-danger btn-sm">Return</a>
                                    @else
                                    N/A
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

<script>
    $(document).on('change', '#status', function() {
        let filter = $(this).find(":selected").val();
        $.ajax({
            url: '{{ route("pos.orders.filter") }}',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                key: filter,
            },
            success: function(res) {
                let tbody = $('#content');
                tbody.html('');

                if (res.length < 1) {
                    tbody.append(`<tr><td colspan="8">No orders yet.</td></tr>`);
                } else {
                    res.forEach((order, index) => {
                        let customerInfo = order.customer ?
                            (order.customer.email || order.customer.phone || order.customer.name) :
                            'N/A';

                        tbody.append(`
                        <tr class="order-item" data-order-id="${order.id}" style="cursor: pointer;">
                            <th scope="row">${index + 1}</th>
                            <td scope="row">${order.id}</td>
                            <td>${customerInfo}</td>
                            <td>
                                ${new Date(order.order_date).toLocaleTimeString()}<br>
                                ${new Date(order.order_date).toLocaleDateString()}
                            </td>
                            <td>${order.total_amount} EGP</td>
                            <td>${order.offer || '0'} %</td>
                            <td>${order.payment_method}</td>
                            <td>${order.status}</td>
                            <td>
                                ${order.status !== 'cancelled' ? 
                                    `<a href="/pos/orders/get-return/${order.id}" class="btn btn-outline-danger btn-sm">Return</a>` : 
                                    'N/A'}
                            </td>
                        </tr>
                    `);
                    });
                }
            },
            error: function(err) {
                toastr.success(err.responseJSON.error);
            }
        });
    });


    // Event delegation to handle dynamically added rows
    $(document).on('click', '.order-item', function() {
        const orderRoute = "{{ route('pos.orders.show', ':id') }}";
        const orderId = $(this).data('order-id');
        const url = orderRoute.replace(':id', orderId);
        window.location.href = url;
    });
</script>
@endsection