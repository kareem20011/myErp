<table class="table table-bordered">
    <div class="table-responsive mt-3">
        <table class="table table-hover">
            <tr>
                <th scope="col">#</th>
                <th scope="col">order id</th>
                <th scope="col">Customer</th>
                <th scope="col">Order Date</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody>
                @if(count($reportData) < 1)
                <tr>
                    <td colspan="6">No product found.</td>
                </tr>
                @endif
                @foreach ($reportData as $index => $order)
                <tr class="order-item" data-order-id="{{ $order['id'] }}" style="cursor: pointer;">
                    <th scope="row">{{ $index + 1 }}</th>
                    <th scope="row">{{ $order['id'] }}</th>
                    <td>{{ $order['customer']['name'] ?? 'N/A' }}</td>
                    <td>{{ date('Y-m-d H:i:s', strtotime($order['order_date'])) }}</td>
                    <td>{{ $order['total_amount'] }} EGP</td>
                    <td>{{ $order['payment_method'] }}</td>
                    <td>{{ $order['status'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $('.order-item').on('click', function() {
            const orderRoute = "{{ route('pos.orders.show', ':id') }}";

            const orderId = $(this).data('order-id');

            const url = orderRoute.replace(':id', orderId);

            window.location.href = url;
        });
    </script>