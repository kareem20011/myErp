@extends('layouts.admin')
@section('title')
Show permissions
@endsection
@section('admin.content')
@if (Session::has('success'))
<script>
  $(document).ready(function() {
    toastr.success("{{ Session::get('success') }}");
  });
</script>
@endif
@error('password')
<script>
  $(document).ready(function() {
    toastr.error("{{ $message }}");
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
          <h1>Permissions</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route( 'dashboard' ) }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Permissions</li>
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
            <h3 class="card-title" style="margin-top: 0.5rem;">Permissions data</h3>
            <div class="card-tools">
              @if(has_permission('create', 'permissions'))
              <div class="input-group input-group-sm" style="width: 150px;">
                <a href="{{ route( 'permissions.create' ) }}" class="card-title btn btn-primary">Create new</a>
              </div>
              @endif
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <th>Name</th>
                <th>View</th>
                <th>Craete</th>
                <th>Update</th>
                <th>Delete</th>
                @if(has_permission('update', 'permissions') || has_permission('delete', 'permissions'))
                <th>Actions</th>
                @endif
              </thead>
              <tbody>
                @foreach($permissionGroups as $group => $permissions)
                <tr>
                  <th>{{ $group }}</th>
                  @foreach(['view', 'create', 'update', 'delete'] as $permission)
                  <td>
                    @if($permissions->firstWhere('name', $permission))
                    <i class="fas fa-check"></i>
                    @endif
                  </td>
                  @endforeach
                  @if(has_permission('update', 'permissions') || has_permission('delete', 'permissions'))
                  <td>
                    <!-- Edit button -->
                    @if(has_permission('update', 'permissions'))
                    <a href="{{ route('permissions.edit', $group) }}" class="btn btn-warning btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                    @endif

                    <!-- Button to trigger the delete modal -->
                    @if(has_permission('delete', 'permissions'))
                    <button type="button" class="btn btn-danger btn-sm" data-route="{{ route('permissions.destroy', $group) }}" onclick="confirmDelete(this)">
                      <i class="fas fa-trash"></i>
                    </button>
                    @endif
                  </td>
                  @endif
                </tr>
                @endforeach

                @if(count($permissionGroups) == 0)
                <tr>
                  <td colspan="8">
                    <div class="alert alert-danger text-center">No data found</div>
                  </td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection