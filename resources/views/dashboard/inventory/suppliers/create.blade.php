@extends('layouts.admin')
@section('title')
Create suppliers
@endsection
@section('admin.content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Create supplier</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route( 'suppliers.index' ) }}">Suppliers</a></li>
            <li class="breadcrumb-item active">Create</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <div class="card card-primary m-3">
    <!-- form start -->
    <form action="{{ route( 'suppliers.store' ) }}" method="post">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="company_name">Company name</label>
          <input name="company_name" type="text" class="form-control" id="company_name" placeholder="enter company name" value="{{ old( 'company_name' ) }}">
        </div>
        @error('company_name')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="contact_person">contact person</label>
          <input name="contact_person" type="text" class="form-control" id="contact_person" placeholder="enter company person" value="{{ old( 'contact_person' ) }}">
        </div>
        @error('contact_person')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="phone">Phone</label>
          <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter phone" value="{{ old( 'phone' ) }}">
        </div>
        @error('phone')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="email">Email address</label>
          <input name="email" type="email" class="form-control" id="email" placeholder="Enter email" value="{{ old( 'email' ) }}">
        </div>
        @error('email')
        <p class="text-danger">{{ $message }}</p>
        @enderror



        <div class="form-group">
          <label for="address">address</label>
          <textarea class="form-control" name="address" id="address" placeholder="Enter address"></textarea>
        </div>
        @error('address')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="notes">notes</label>
          <textarea class="form-control" name="notes" id="notes" placeholder="Enter notes"></textarea>
        </div>
        @error('notes')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <hr>

        <div class="custom-control custom-checkbox">
          <input name="status" class="custom-control-input" type="checkbox" id="status" checked="">
          <label for="status" class="custom-control-label">Status active</label>
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