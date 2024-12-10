@extends('layouts.admin')
@section('title')
Show subcategories
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
                    <h1>subcategories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'dashboard' ) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">subcategories</li>
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
                        <h3 class="card-title">subcategories data</h3>
                        <div class="card-tools">
                            @if(has_permission('create', 'subcategories'))
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <a href="{{ route( 'subcategories.create' ) }}" class="card-title btn btn-primary">Create new</a>
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
                                    <th>Main category</th>
                                    @if(has_permission('update', 'subcategories') || has_permission('delete', 'subcategories'))
                                    <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                <tr>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->category->name }}</td>
                                    @if(has_permission('update', 'subcategories') || has_permission('delete', 'subcategories'))
                                    <td>
                                        <!-- Edit button -->
                                        @if(has_permission('update', 'subcategories'))
                                        <a href="{{ route('subcategories.edit', $row->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif

                                        <!-- Button to trigger the delete modal -->
                                        @if(has_permission('delete', 'subcategories'))
                                        <button type="button" class="btn btn-danger btn-sm" data-route="{{ route('subcategories.destroy', $row->id) }}" onclick="confirmDelete(this)">
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