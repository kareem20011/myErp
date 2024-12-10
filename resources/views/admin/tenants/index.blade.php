@extends('layouts.admin')
@section('title')
Show tenants
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
                    <h1>tenants</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">tenants</li>
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
                        <h3 class="card-title">tenants data</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <a href="{{ route( 'admin.tenants.create' ) }}" class="card-title btn btn-primary">Create new</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Picture</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>email</th>
                                    <th>address</th>
                                    <th>status</th>
                                    <th>created_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                <tr>
                                    <td>
                                        @if($row->hasMedia('images'))
                                        <img class="img-circle elevation-2" src="{{ $row->getFirstMediaUrl('images') }}" alt="Avatar" width="50">
                                        @else
                                        <img class="img-circle elevation-2" src="{{ asset( 'assets/images/AdminLTELogo.png' ) }}" alt="Avatar" width="50">
                                        @endif
                                    </td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->address }}</td>
                                    <td>{{ $row->status }}</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="{{ route( 'admin.tenants.show', $row->id ) }}">
                                            <i class="fas fa-sign-in-alt"></i>
                                        </a>
                                    </td>
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