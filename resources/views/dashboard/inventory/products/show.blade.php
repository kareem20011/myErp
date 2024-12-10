@extends('layouts.admin')
@section('title')
Show product | {{ $row->name }}
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
                        <li class="breadcrumb-item"><a href="{{ route( 'products.index' ) }}">products</a></li>
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
                        <h3 class="card-title">product data</h3>
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
                                <th>name</th>
                                <td>{{ $row->name }}</td>
                            </tr>

                            <tr>
                                <th>description</th>
                                <td>{{ $row->description }}</td>
                            </tr>

                            <tr>
                                <th>price</th>
                                <td>{{ $row->price }}</td>
                            </tr>

                            <tr>
                                <th>unit</th>
                                <td>{{ $row->unit }}</td>
                            </tr>

                            <tr>
                                <th>barcode</th>
                                <td>{{ $row->barcode }}</td>
                            </tr>

                            <tr>
                                <th>quantity</th>
                                <td>{{ $row->quantity }}</td>
                            </tr>

                            <tr>
                                <th>threshold</th>
                                <td>{{ $row->threshold }}</td>
                            </tr>

                            <tr>
                                <th>status</th>
                                <td>{{ $row->status }}</td>
                            </tr>

                            <tr>
                                <th>subcategory</th>
                                <td>{{ $row->subcategory->name  }}</td>
                            </tr>

                            <tr>
                                <th>supplier</th>
                                <td><a href="{{ route( 'suppliers.show', $row->supplier->id ) }}">{{ $row->supplier->company_name }}</a></td>
                            </tr>

                            <tr>
                                <th>created by</th>
                                <td><a href="{{ route( 'users.show', $row->created_by->id ) }}">{{ $row->created_by->email }}</a></td>
                            </tr>

                            <tr>
                                <th>updated by</th>
                                <td>
                                    @if(isset($row->updated_by))
                                    <a href="{{ route( 'users.show', $row->updated_by->id ) }}">{{ $row->updated_by->email }}</a>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>created at</th>
                                @if(isset($row->created_at))
                                <td>
                                    {{ date('h:i:s A', strtotime($row->created_at)) }}
                                    <br>
                                    {{ date('Y-m-d', strtotime($row->created_at)) }}
                                </td>
                                @else
                                <td>-</td>
                                @endif
                            </tr>

                            <tr>
                                <th>last update</th>
                                @if(isset($row->updated_at))
                                <td>
                                    {{ date('h:i:s A', strtotime($row->updated_at)) }}
                                    <br>
                                    {{ date('Y-m-d', strtotime($row->updated_at)) }}
                                </td>
                                @else
                                <td>-</td>
                                @endif
                            </tr>

                        </table>
                        <div class="my-2">
                            <!-- Edit button -->
                            @if(has_permission('update', 'products'))
                            <a href="{{ route( 'products.edit', $row->id ) }}" type="submit" class="btn btn-primary btn-sm text-white">Edit</a>

                            <!-- quantity Edit button -->
                            <a href="{{ route( 'inventory.logs.edit', $row->id ) }}" type="submit" class="btn btn-info btn-sm text-white">Edit quantity</a>
                            @endif

                            <!-- Button to trigger the delete modal -->
                            @if(has_permission('delete', 'products'))
                            <button type="button" class="btn btn-danger btn-sm" data-route="{{ route('products.destroy', $row->id) }}" onclick="confirmDelete(this)">Delete</button>
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