@extends('layouts.admin')
@section('title')
Show products
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
          <h1>products</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route( 'dashboard' ) }}">Dashboard</a></li>
            <li class="breadcrumb-item active">products</li>
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
            <div class="card-title">
              <form action="{{ route( 'products.search' ) }}" method="post">
                @csrf
                <div class="input-group">
                  <input name="query" value="{{ isset($query) ? $query : '' }}" type="text" placeholder="Search" class="form-control">
                  <button class="btn btn-info btn-sm">Search</button>
                </div>
              </form>
            </div>
            @if(has_permission('create', 'products'))
            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px;">
                <a href="{{ route( 'products.create' ) }}" class="card-title btn btn-primary">Create new</a>
              </div>
            </div>
            @endif
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>picture</th>
                  <th>name</th>
                  <th>description</th>
                  <th>price</th>
                  <th>unit</th>
                  <th>barcode</th>
                  <th>quantity</th>
                  <th>threshold</th>
                  <th>status</th>
                  <th>subcategory</th>
                  <th>supplier</th>
                  <th>actions</th>
                </tr>
              </thead>
              <tbody id="results">
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
                  <td>{{ $row->description }}</td>
                  <td>{{ $row->price }} EGP</td>
                  <td>{{ $row->unit }}</td>
                  <td>{{ $row->barcode }}</td>
                  <td>{{ $row->quantity }}</td>
                  <td>{{ $row->threshold }}</td>
                  <td>{{ $row->status }}</td>
                  <td>{{ $row->subcategory->name }}</td>
                  <td><a href="{{ route( 'suppliers.show', $row->supplier->id ) }}">{{ $row->supplier->company_name }}</a></td>

                  <!-- Info button -->
                  <td>
                    <a href="{{ route( 'products.show', $row->id ) }}" class="btn btn-info btn-sm">
                      <i class="fas fa-info-circle"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
                @if(count($data) == 0)
                <tr>
                  <td colspan="12">
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