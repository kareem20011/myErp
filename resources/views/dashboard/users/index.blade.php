@extends('layouts.admin')
@section('title')
Show users
@endsection
@section('admin.content')
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
          <h1>Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route( 'dashboard' ) }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
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
            <h3 class="card-title">Users data</h3>
            <div class="card-tools">
              @if(has_permission('create', 'users'))
              <div class="input-group input-group-sm" style="width: 150px;">
                <a href="{{ route( 'users.create' ) }}" class="card-title btn btn-primary">Create new</a>
              </div>
              @endif
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Profile picture</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>dd / mm / yy</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $row)
                <tr>
                  <td>
                    @if($row->hasMedia('images'))
                    <img class="img-circle elevation-2" src="{{ $row->getFirstMediaUrl('images') }}" alt="Avatar" width="50">
                    @else
                    <img class="img-circle elevation-2" src="{{ asset( 'assets/images/avatar.png' ) }}" alt="Avatar" width="50">
                    @endif
                  </td>
                  <td>{{ $row->name }}</td>
                  <td>{{ $row->email }}</td>
                  <td>{{ $row->phone }}</td>
                  <td>{{ $row->day }} / {{ $row->month }} / {{ $row->year }}</td>
                  <td>
                    @if($row->role)
                    <a href="{{ route( 'roles.edit', $row->role_id ) }}">{{ $row->role->name }}</a>
                    @else
                    -
                    @endif
                  </td>
                  <td>{{ $row->status == 1 ? 'Active' : 'Inactive' }}</td>
                  <td>
                    <a href="{{ route( 'users.show', $row->id ) }}" class="btn btn-info btn-sm">
                      <i class="fas fa-info-circle"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
                @if(count($data) == 0)
                <tr>
                  <td colspan="8">
                    <div class="alert alert-danger text-center">No data found</div>
                  </td>
                </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="5">{{ $data->links() }}</th>
                </tr>
              </tfoot>
            </table>
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