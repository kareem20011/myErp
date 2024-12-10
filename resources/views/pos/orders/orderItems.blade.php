@extends('layouts.pos')
@section('pos.content')
<div style="overflow: hidden;" class="pt-5 pb-2 border-bottom">
    <div style="float: right;">
        <a href="{{ route( 'pos.orders' ) }}">orders</a> /
        <span class="text-secondary">order details</span>
    </div>
</div>

<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span><strong>Date:</strong> {{ date('Y-m-d', strtotime($order->order_date)) }} / {{ date('h:i:s A', strtotime($order->order_date)) }}</span>
            <span><strong>Customer:</strong>
                @if( $order->customer )
                @if( $order->customer->email )
                {{ $order->customer->email }}
                @elseif( $order->customer->phone )
                {{ $order->customer->phone }}
                @else
                {{ $order->customer->name }}
                @endif
                @else
                -
                @endif
            </span>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">picture</th>
                            <th scope="col">product name</th>
                            <th scope="col">unit price</th>
                            <th scope="col">quantity</th>
                            <th scope="col">total price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $order->orderItems as $index => $item)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>
                                @if($item->product->hasMedia('images'))
                                <img class="img-circle elevation-2" width="50" src="{{ $item->product->getFirstMediaUrl( 'images' ) }}" alt="">
                                @endif
                            </td>
                            <td scope="row">{{ $item->product->name }}</td>
                            <td scope="row">{{ $item->unit_price }} EGP</td>
                            <td scope="row">{{ $item->quantity }}</td>
                            <td scope="row">{{ $item->total_price }} EGP</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection