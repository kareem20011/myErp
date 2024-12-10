@extends('layouts.admin')
@section('title')
Edit product | {{ $row['name'] }}
@endsection
@section('admin.content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit {{ $row['name'] }} qty</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'products.show', $row['id'] ) }}">products</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card card-primary m-3">
        <!-- form start -->
        <form action="{{ route( 'inventory.logs.update', $row['id'] ) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">


                <div class="form-group">
                    <label for="quantity">quantity</label>
                    <input name="quantity" type="number" min="0" class="form-control" id="quantity" placeholder="Enter quantity" value="{{ $row['quantity'] }}" required>
                </div>
                @error('quantity')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="reason">reason</label>
                    <input name="reason" type="text" id="reason" class="form-control" placeholder="Enter reason" value="{{ old( 'reason' ) }}" required>
                </div>
                @error('reason')
                <p class="text-danger">{{ $message }}</p>
                @enderror

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection