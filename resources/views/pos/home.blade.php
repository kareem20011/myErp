@extends('layouts.pos')
@section('pos.content')

<div class="home-container">
    <div>
        <img class="home-icon" src="{{ asset( 'assets/icons/house.png' ) }}" alt="icon" /><br>
        <span class="d-block text-center">Home</span>
    </div>
    <div>
        <img class="home-icon" src="{{ asset( 'assets/icons/product.png' ) }}" alt="icon" />
        <span class="d-block text-center">Home</span>
    </div>
    <div>
        <img class="home-icon" src="{{ asset( 'assets/icons/invoice.png' ) }}" alt="icon" />
        <span class="d-block text-center">Home</span>
    </div>
    <div>
        <img class="home-icon" src="{{ asset( 'assets/icons/report.png' ) }}" alt="icon" />
        <span class="d-block text-center">Home</span>
    </div>
    <div>
        <img class="home-icon" src="{{ asset( 'assets/icons/dashboard.png' ) }}" alt="icon" />
        <span class="d-block text-center">Home</span>
    </div>
</div>

@endsection