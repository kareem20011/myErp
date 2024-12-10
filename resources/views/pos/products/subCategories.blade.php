@extends('layouts.pos')
@section('pos.content')

<div style="overflow: hidden;" class="pt-5 pb-2 border-bottom">
    <div style="float: right;">
        <a href="{{ route( 'pos.products.mainCategories' ) }}">Main categories</a> /
        <span class="text-secondary">{{ $mainCategory->name }}</span>
    </div>
</div>

<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Sub categories</h3>
        </div>
        <div class="card-body d-flex flex-wrap justify-content-center align-items-center">
            @if(count($mainCategory->subcategories) < 1)
                <div class="alert alert-warning">No subcategories found.</div>
            @else
                @foreach($mainCategory->subcategories as $row)
                    <a href="{{ route('pos.products', $row->id) }}" class="mainCategory text-white px-3 py-2 mb-3 ml-3 btn btn-sm">
                        <i class="fas fa-tag mr-2"></i>
                        {{$row->name}}
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</div>

@include('pos.products.scripts')

@endsection
