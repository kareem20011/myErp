@extends('layouts.admin')
@section('title')
Show Inventory logs
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
                    <h1>Inventory logs</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'dashboard' ) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Inventory logs</li>
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
                        <h3 class="card-title">Inventory logs data</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>product name</th>
                                    <th>change type</th>
                                    <th>quantity changed</th>
                                    <th>reason</th>
                                    <th>updated by</th>
                                    <th>created at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                <tr>
                                    <td><a href="{{ route( 'products.show', $row->product->id ) }}">{{ $row->product->name }}</a></td>
                                    <td>{{ $row->change_type }}</td>
                                    <td>{{ $row->quantity_changed }}</td>
                                    <td>{{ $row->reason }}</td>
                                    <td><a href="{{ route( 'users.show', $row->user->id ) }}">{{ $row->user->name }}</a></td>
                                    <td>
                                        {{ date('h:i:s A', strtotime($row->created_at)) }}
                                        <br>
                                        {{ date('Y-m-d', strtotime($row->created_at)) }}
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