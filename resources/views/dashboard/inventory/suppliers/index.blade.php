@extends('layouts.admin')
@section('title')
Show suppliers
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
                    <h1>Suppliers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'dashboard' ) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Suppliers</li>
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
                        <h3 class="card-title">Suppliers data</h3>
                        @if(has_permission('create', 'suppliers'))
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <a href="{{ route( 'suppliers.create' ) }}" class="card-title btn btn-primary">Create new</a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Company name</th>
                                    <th>Contact person</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Notes</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                <tr>
                                    <td>{{ $row->company_name }}</td>
                                    <td>{{ $row->contact_person }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->address }}</td>
                                    <td>{{ $row->notes }}</td>
                                    <td>{{ $row->status }}</td>
                                    <td>
                                        <a href="{{ route( 'suppliers.show', $row->id ) }}" class="btn btn-info btn-sm">
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