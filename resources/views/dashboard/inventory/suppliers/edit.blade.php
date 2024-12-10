@extends('layouts.admin')
@section('title')
Edit supplier | {{ $row->company_name }}
@endsection
@section('admin.content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit supplier</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'suppliers.show', $row->id ) }}">Back</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card card-primary m-3">
        <!-- form start -->
        <form action="{{ route( 'suppliers.update', $row->id ) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="company_name">company name</label>
                    <input name="company_name" type="text" class="form-control" id="company_name" placeholder="Enter company name" value="{{ $row->company_name }}">
                </div>
                @error('company_name')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="contact_person">contact person</label>
                    <input name="contact_person" type="text" class="form-control" id="contact_person" placeholder="Enter contact person" value="{{ $row->contact_person }}">
                </div>
                @error('contact_person')
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
                    <label for="email">Email address</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Enter email" value="{{ $row->email }}">
                </div>
                @error('email')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label id="address">address</label>
                    <textarea class="form-control" name="address" id="address">{{ $row->address }}</textarea>
                </div>
                @error('address')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label id="notes">note</label>
                    <textarea class="form-control" name="notes" id="notes">{{ $row->notes }}</textarea>
                </div>
                @error('notes')
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