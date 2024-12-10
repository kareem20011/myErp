@extends('layouts.admin')
@section('title')
Create tenant
@endsection
@section('admin.content')
@error('error')
<script>
    $(document).ready(function() {
        toastr.error("{{ $message }}");
    });
</script>
@enderror
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create tenant</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'admin.tenants.index' ) }}">tenants</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card card-primary m-3">
        <!-- form start -->
        <form action="{{ route( 'admin.tenants.store' ) }}" method="post" enctype="multipart/form-data">
            @csrf
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
                    <label for="group">name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter name">
                </div>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="group">phone</label>
                    <input type="text" class="form-control" name="phone" placeholder="Enter phone">
                </div>
                @error('phone')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="group">email</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter email">
                </div>
                @error('email')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="group">address</label>
                    <input type="text" class="form-control" name="address" placeholder="Enter address">
                </div>
                @error('address')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="custom-control custom-checkbox">
                    <input name="status" class="custom-control-input" type="checkbox" id="status" checked="">
                    <label for="status" class="custom-control-label">check to active</label>
                </div>
                @error('status')
                <p class="text-danger">{{ $message }}</p>
                @enderror

            </div>


            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection