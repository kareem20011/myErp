@extends('layouts.pos')

@section('pos.content')
<div class="container mt-2">
    <h1 class="text-center">Reports</h1>
    <ul class="nav nav-tabs" id="reportTabs">
        <li class="nav-item">
            <a class="nav-link active" id="sales-tab" data-toggle="tab" href="#sales-report">Sales Report</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="top-products-tab" data-toggle="tab" href="#top-products-report">Top Selling Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="returned-products-tab" data-toggle="tab" href="#returned-products-report">customers</a>
        </li>
    </ul>
    <div class="tab-content mt-4">
        <div class="tab-pane fade show active" id="sales-report">
            @include('pos.reports.includes.sales.index')
        </div>
        <div class="tab-pane fade" id="top-products-report">
            @include('pos.reports.includes.top_products')
        </div>
        <div class="tab-pane fade" id="returned-products-report">
            @include('pos.reports.includes.customers')
        </div>
    </div>
</div>
@endsection
