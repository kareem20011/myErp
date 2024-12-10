@extends('layouts.admin')
@section('title')
Edit User | {{ $row->name }}
@endsection
@section('admin.content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit user</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route( 'users.show', $row->id ) }}">Back</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <div class="card card-primary m-3">
    <!-- form start -->
    <form action="{{ route( 'users.update', $row->id ) }}" method="post" enctype="multipart/form-data">
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
          <label for="email">Email address</label>
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
          <label>Birth date</label>
          <div class="input-group">
            <input name="day" type="number" class="form-control" placeholder="Day" value="{{ $row->day }}">
            <input name="month" type="number" class="form-control" placeholder="Month" value="{{ $row->month }}">
            <input name="year" type="number" class="form-control" placeholder="Year" value="{{ $row->year }}">
          </div>
        </div>
        @error('day')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        @error('month')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        @error('year')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label>Role</label>
          <select name="role_id" class="form-control">
            <option selected disabled>Select role</option>
            @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ old('role_id', $row->role_id) == $role->id ? 'selected' : '' }}>
              {{ $role->name }}
            </option>
            @endforeach
          </select>
        </div>
        @error('role_id')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="password">Password</label>
          <input name="password" type="password" class="form-control" id="password" placeholder="Password">
        </div>
        @error('password')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="password_confirmation">Retype password</label>
          <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Retype password">
        </div>
        @error('password_confirmation')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <hr>

        <div class="custom-control custom-checkbox">
          <input name="status" class="custom-control-input" type="checkbox" id="status" {{ $row->status == '1' ? 'checked' : ''}}>
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