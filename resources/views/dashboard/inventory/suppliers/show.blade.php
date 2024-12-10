@extends('layouts.admin')
@section('title')
Show supplier | {{ $row->company_name }}
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
                    <h1>{{ $row->company_name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'suppliers.index' ) }}">Suppliers</a></li>
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
                        <h3 class="card-title">Supplier data</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <tr>
                                <th>company name</th>
                                <td>{{ $row->company_name }}</td>
                            </tr>

                            <tr>
                                <th>contact person</th>
                                <td>{{ $row->contact_person }}</td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td>{{ $row->phone }}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{ $row->email }}</td>
                            </tr>

                            <tr>
                                <th>address</th>
                                <td>{{ $row->address }}</td>
                            </tr>

                            <tr>
                                <th>related products</th>
                                <td>
                                    <ul class="myul">
                                        @foreach($row->products as $product)
                                        <li><a href="{{ route( 'products.show', $product->id ) }}">{{ $product->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <th>notes</th>
                                <td>{{ $row->notes }}</td>
                            </tr>

                            <tr>
                                <th>status</th>
                                <td>{{ $row->status }}</td>
                            </tr>

                            <tr>
                                <th>Created by</th>
                                @if(isset($row->created_by))
                                <td><a href="{{ route( 'users.show', $row->created_by->id ) }}">{{ $row->created_by->email }}</a></td>
                                @else
                                <td>-</td>
                                @endif
                            </tr>

                            <tr>
                                <th>Updated by</th>
                                @if(isset($row->updated_by))
                                <td><a href="{{ route( 'users.show', $row->updated_by->id ) }}">{{ $row->updated_by->email }}</a></td>
                                @else
                                <td>-</td>
                                @endif
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
                            @if(has_permission('update', 'suppliers'))
                            <a href="{{ route( 'suppliers.edit', $row->id ) }}" type="submit" class="btn btn-primary text-white">Edit</a>
                            @endif
                            <!-- Button to trigger the delete modal -->
                            @if(has_permission('delete', 'suppliers'))
                            <button type="button" class="btn btn-danger" data-route="{{ route('suppliers.destroy', $row->id) }}" onclick="confirmDelete(this)">Delete</button>
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