@extends('layouts.pos')
@section('pos.content')
<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">Main categories</h3>
        </div>
        <div class="card-body d-flex flex-wrap justify-content-center align-items-center w-100">
            @if(count($mainCategories) < 1)
            <div class="alert alert-warning">No main categories found.</div>
            @endif
            @foreach($mainCategories as $row)
            <a href="{{ route('pos.products.subcategories', $row->id) }}" class="mainCategory text-white px-3 py-2 mb-3 ml-3 btn btn-sm">
                <i class="fas fa-tag mr-2"></i>
                {{$row->name}}
            </a>
            @endforeach
        </div>
    </div>
</div>

@include('pos.products.scripts')

@endsection