@extends('layouts.admin')
@section('title')
Edit tenant | {{ $row->name }}
@endsection
@section('admin.content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit tenant</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'admin.tenants.show', $row->id ) }}">Back</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card card-primary m-3">
        <!-- form start -->
        <form action="{{ route( 'admin.tenants.update', $row->id ) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="image">Profile picture</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input name="image" type="file" class="custom-file-input" id="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter name" value="{{ $row->name }}">
                </div>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Enter email" value="{{ $row->email }}">
                </div>
                @error('email')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter phone" value="{{ $row->phone }}">
                </div>
                @error('phone')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="address">address</label>
                    <input name="address" type="text" class="form-control" id="address" placeholder="Enter address" value="{{ $row->address }}">
                </div>
                @error('address')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <hr>

                <div class="custom-control custom-checkbox">
                    <input name="status" class="custom-control-input" type="checkbox" id="status" {{ $row->status == 'active' ? 'checked' : ''}}>
                    <label for="status" class="custom-control-label">Status active</label>
                </div>
                @error('status')
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