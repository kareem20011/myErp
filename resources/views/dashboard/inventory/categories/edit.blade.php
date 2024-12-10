@extends('layouts.admin')
@section('title')
Edit category | {{ $row->name }}
@endsection
@section('admin.content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'categories.show', $row->id ) }}">Back</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card card-primary m-3">
        <!-- form start -->
        <form action="{{ route( 'categories.update', $row->id ) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter company name" value="{{ $row->name }}">
                </div>
                @error('name')
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