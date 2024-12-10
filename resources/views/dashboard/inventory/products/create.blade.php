@extends('layouts.admin')
@section('title')
Create product
@endsection
@section('admin.content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Create product</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route( 'products.index' ) }}">products</a></li>
            <li class="breadcrumb-item active">Create</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <div class="card card-primary m-3">
    <!-- form start -->
    <form action="{{ route( 'products.store' ) }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="image">Profile picture</label>
          <div class="input-group">
            <div class="custom-file">
              <input name="image" type="file" class="custom-file-input" id="image">
              <label class="custom-file-label" for="image">Choose file</label>
            </div>
            <div class="input-group-append">
              <span class="input-group-text" id="">Upload</span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="name">Name</label>
          <input name="name" type="text" class="form-control" id="name" placeholder="Enter name" value="{{ old( 'name' ) }}">
        </div>
        @error('name')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="description">description</label>
          <input name="description" type="text" class="form-control" id="description" placeholder="Enter description" value="{{ old( 'description' ) }}">
        </div>
        @error('description')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="price">price</label>
          <input name="price" type="number" class="form-control" id="price" step="0.1" min="0" placeholder="0.0" value="{{ old( 'price' ) }}">
        </div>
        @error('price')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="unit">unit</label>
          <input name="unit" type="text" class="form-control" id="unit" placeholder="Enter unit" value="{{ old( 'unit' ) }}">
        </div>
        @error('unit')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="barcode">barcode</label>
          <input name="barcode" type="text" class="form-control" id="barcode" placeholder="Enter barcode" value="{{ old( 'barcode' ) }}">
        </div>
        @error('barcode')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="quantity">quantity</label>
          <input name="quantity" type="number" class="form-control" id="quantity" placeholder="Enter quantity" value="{{ old( 'quantity' ) }}">
        </div>
        @error('quantity')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="threshold">threshold</label>
          <input name="threshold" type="number" class="form-control" id="threshold" placeholder="Enter threshold" value="{{ old( 'threshold' ) }}">
        </div>
        @error('threshold')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="status">status</label>
          <select id="status" name="status" class="form-control">
            <option selected disabled>Choose option</option>
            <option value="active">active</option>
            <option value="inactive">inactive</option>
            <option value="onRequest">on request</option>
          </select>
        </div>
        @error('status')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="subcategory_id">subcategory</label>
          <select id="subcategory_id" name="subcategory_id" class="form-control">
            <option selected disabled>Choose option</option>
            @foreach($subcategories as $sub)
            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
            @endforeach
          </select>
        </div>
        @error('subcategory_id')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <div class="form-group">
          <label for="supplier_id">supplier</label>
          <select id="supplier_id" name="supplier_id" class="form-control">
            <option selected disabled>Choose option</option>
            @foreach($suppliers as $supplier)
            <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
            @endforeach
          </select>
        </div>
        @error('supplier_id')
        <p class="text-danger">{{ $message }}</p>
        @enderror

      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
    </form>
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection