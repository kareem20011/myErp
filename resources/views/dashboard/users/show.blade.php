@extends('layouts.admin')
@section('title')
Show users | {{ $row->name }}
@endsection
@section('admin.content')
@error('password')
<script>
  $(document).ready(function() {
    toastr.error("{{ $message }}");
  });
</script>
@endif
@if (Session::has('success'))
<script>
  $(document).ready(function() {
    toastr.success("{{ Session::get('success') }}");
  });
</script>
@endif
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $row->name }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route( 'users.index' ) }}">Users</a></li>
            <li class="breadcrumb-item active">Show</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">User data</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <tr>
                <th>Profile picture</th>
                <td>
                  @if($row->hasMedia('images'))
                  <img class="img-circle elevation-2" src="{{ $row->getFirstMediaUrl('images') }}" alt="Avatar" width="100">
                  @else
                  <img class="img-circle elevation-2" src="{{ asset( 'assets/images/avatar.png' ) }}" alt="Avatar" width="100">
                  @endif
                </td>
              </tr>
              <tr>
                <th>Name</th>
                <td>{{ $row->name }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $row->email }}</td>
              </tr>
              <tr>
                <th>Phone</th>
                <td>{{ $row->phone }}</td>
              </tr>
              <tr>
                <th>Birthdate</th>
                <td>{{ $row->day }} / {{ $row->month }} / {{ $row->year }}</td>
              </tr>
              <tr>
                <th>Role</th>
                <td>
                  @if($row->role)
                  <a href="{{ route( 'roles.edit', $row->role_id ) }}">{{ $row->role->name }}</a>
                  @else
                  -
                  @endif
                </td>
              </tr>
              <tr>
                <th>Status</th>
                <td>{{ $row->status == 1 ? 'Active' : 'Inactive' }}</td>
              </tr>
              <tr>
                <th>Created by</th>
                @if(isset($creator))
                <td><a href="{{ route( 'users.show', $creator->id ) }}">{{ $creator->name }}</a></td>
                @else
                <td>-</td>
                @endif
              </tr>
              <tr>
                <th>Updated by</th>
                @if(isset($editor))
                <td><a href="{{ route( 'users.show', $editor->id ) }}">{{ $editor->name }}</a></td>
                @else
                <td>-</td>
                @endif
              </tr>

            </table>
            <div class="my-2">
              <!-- Edit button -->
              @if(has_permission('update', 'users'))
              <a href="{{ route( 'users.edit', $row->id ) }}" type="submit" class="btn btn-primary text-white">Edit</a>
              @endif
              <!-- Button to trigger the delete modal -->
              @if(has_permission('delete', 'users'))
              <button type="button" class="btn btn-danger" data-route="{{ route('users.destroy', $row->id) }}" onclick="confirmDelete(this)">Delete</button>
              @endif
            </div>


          </div>
          <!-- /.card-body -->
        </div>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection