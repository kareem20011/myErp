@extends('layouts.admin')
@section('title')
Show low stock notifications
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
                    <h1>low stock notifications</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'dashboard' ) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">low stock notifications</li>
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
                        <h3 class="card-title">low stock notifications data</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>picture</th>
                                    <th>product</th>
                                    <th>alert</th>
                                    <th>status</th>
                                    <th>resolved at</th>
                                    <th>resolved by</th>
                                    <th>created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                <tr>
                                    <td>
                                        @if($row->product->hasMedia('images'))
                                        <img class="img-circle elevation-2" src="{{ $row->product->getFirstMediaUrl('images') }}" alt="Avatar" width="50">
                                        @else
                                        <img class="img-circle elevation-2" src="{{ asset( 'assets/images/avatar.png' ) }}" alt="Avatar" width="50">
                                        @endif
                                    </td>
                                    <td><a href="{{ route( 'products.show', $row->product->id ) }}">{{ $row->product->name }}</a></td>
                                    @if($row->status == 'unresolved')
                                    <td class="text-danger">
                                        <strong>Stock Alert:</strong> Min stock: <strong>{{ $row->product->threshold }}</strong>, Current: <strong>{{ $row->product->quantity }}</strong>.
                                    </td>
                                    @else
                                    <td class="text-success">
                                        <strong>Stock Alert:</strong> Min stock: <strong>{{ $row->product->threshold }}</strong>, Current: <strong>{{ $row->product->quantity }}</strong> (Resolved).
                                    </td>
                                    @endif
                                    <td>{{ $row->status }}</td>
                                    @if(isset($row->resolved_at))
                                    <td>
                                        {{ date('h:i:s A', strtotime($row->resolved_at)) }}
                                        <br>
                                        {{ date('Y-m-d', strtotime($row->resolved_at)) }}
                                    </td>
                                    <td>
                                        <a href="{{ route( 'users.show', $row->user->id ) }}">{{ $row->user->name }}</a>
                                    </td>
                                    @else
                                    <td>-</td>
                                    <td>null</td>
                                    @endif

                                    @if(isset($row->created_at))
                                    <td>
                                        {{ date('h:i:s A', strtotime($row->created_at)) }}
                                        <br>
                                        {{ date('Y-m-d', strtotime($row->created_at)) }}
                                    </td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td>
                                        <!-- Button to trigger the delete modal -->
                                        @if(has_permission('delete', 'LowStockNotification'))
                                        <button type="button" class="btn btn-danger btn-sm" data-route="{{ route('low.stock.destroy', $row->id) }}" onclick="confirmDelete(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
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