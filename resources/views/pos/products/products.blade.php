@extends('layouts.pos')
@section('pos.content')


<div style="overflow: hidden;" class="pt-5 pb-2 border-bottom">
    <div style="float: right;">
        <a href="{{ route( 'pos.products.subcategories', $subCategory->category->id ) }}">Sub categories</a> /
        <span class="text-secondary">{{ $subCategory->name }}</span>
    </div>
</div>


<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">products</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">picture</th>
                            <th scope="col">name</th>
                            <th scope="col">description</th>
                            <th scope="col">price</th>
                            <th scope="col">barcode</th>
                            <th scope="col">quantity</th>
                            <th scope="col">threshold</th>
                            <th scope="col">supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($subCategory->products) < 1)
                        <tr>
                            <td colspan="9">
                                no products found.
                            </td>
                        </tr>
                        @endif
                        @foreach($subCategory->products as $index => $product)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>
                                @if($product->hasMedia('images'))
                                <img class="img-circle elevation-2" src="{{ $product->getFirstMediaUrl('images') }}" alt="Avatar" width="50">
                                @else
                                N/A
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }} EGP</td>
                            <td>{{ $product->barcode }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->threshold }}</td>
                            <td>{{ $product->supplier->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
@endsection