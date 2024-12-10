@extends('layouts.admin')
@section('title')
Show roles
@endsection
@section('admin.content')
@if (Session::has('success'))
<script>
  $(document).ready(function() {
    toastr.success("{{ Session::get('success') }}");
  });
</script>
@endif
@session('error')
<script>
  $(document).ready(function() {
    toastr.error("{{ session( 'error' ) }}");
  });
</script>
@endsession
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Roles</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route( 'dashboard' ) }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Roles</li>
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
            <h3 class="card-title" style="margin-top: 0.5rem;">Roles data</h3>
            <div class="card-tools">
              @if(has_permission('create', 'roles'))
              <div class="input-group input-group-sm" style="width: 150px;">
                <a href="{{ route( 'roles.create' ) }}" class="card-title btn btn-primary">Create new</a>
              </div>
              @endif
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  @if(has_permission('update', 'roles') || has_permission('delete', 'roles'))
                  <th>
                    Actions
                  </th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach($data as $row)
                <tr>
                  <td>{{ $row->name }}</td>
                  @if(has_permission('update', 'roles') || has_permission('delete', 'roles'))
                  <td>
                    <!-- Edit button -->
                    @if(has_permission('update', 'roles'))
                    <a href="{{ route( 'roles.edit', $row->id ) }}" class="btn btn-warning btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                    @endif
                    <!-- Button to trigger the delete modal -->
                    @if(has_permission('delete', 'roles'))
                    <button type="button" class="btn btn-danger btn-sm" data-route="{{ route('roles.destroy', $row->id) }}" onclick="confirmDelete(this)">
                      <i class="fas fa-trash"></i>
                    </button>
                    @endif
                  </td>
                  @endif
                </tr>
                @endforeach
                @if(count($data) == 0)
                <tr>
                  <td colspan="7">
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