@extends('layouts.admin')
@section('title')
Edit product | {{ $row->name }}
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
        <div class="text-center mt-5">
            <img width="150" src="{{ $row->getFirstMediaUrl( 'images' ) }}" alt="User profile picture">
        </div>
        <form action="{{ route( 'products.update', $row->id ) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter name" value="{{ $row->name }}">
                </div>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="description">description</label>
                    <input name="description" type="text" class="form-control" id="description" placeholder="Enter description" value="{{ $row->description }}">
                </div>
                @error('description')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="price">price</label>
                    <input name="price" type="number" class="form-control" id="price" step="0.1" min="0" placeholder="0.0" value="{{ $row->price }}">
                </div>
                @error('price')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="unit">unit</label>
                    <input name="unit" type="text" class="form-control" id="unit" placeholder="Enter unit" value="{{ $row->unit }}">
                </div>
                @error('unit')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="barcode">barcode</label>
                    <input name="barcode" type="text" class="form-control" id="barcode" placeholder="Enter barcode" value="{{ $row->barcode }}">
                </div>
                @error('barcode')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="threshold">threshold</label>
                    <input name="threshold" type="number" min="1" class="form-control" id="threshold" placeholder="Enter threshold" value="{{ $row->threshold }}">
                </div>
                @error('threshold')
                <p class="text-danger">{{ $message }}</p>
                @enderror
                @error('quantity')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="status">status</label>
                    <select id="status" name="status" class="form-control">
                        <option selected disabled>Choose option</option>
                        <option {{ $row->status == 'active' ? 'selected' : '' }} value="active">active</option>
                        <option {{ $row->status == 'inactive' ? 'selected' : '' }} value="inactive">inactive</option>
                        <option {{ $row->status == 'onRequest' ? 'selected' : '' }} value="onRequest">on request</option>
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
                        <option {{ $row->subcategory_id == $sub->id ? 'selected' : '' }} value="{{ $sub->id }}">{{ $sub->name }}</option>
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
                        <option {{ $row->supplier_id == $supplier->id ? 'selected' : '' }} value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('supplier_id')
                <p class="text-danger">{{ $message }}</p>
                @enderror

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection