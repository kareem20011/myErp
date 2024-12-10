@extends('layouts.admin')
@section('title')
Create subcategory
@endsection
@section('admin.content')
@error('error')
<script>
    $(document).ready(function() {
        toastr.error("{{ $message }}");
    });
</script>
@enderror
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create subcategory</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'subcategories.index' ) }}">subcategories</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card card-primary m-3">
        <!-- form start -->
        <form action="{{ route( 'subcategories.store' ) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="group">name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter name">
                </div>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="category_id">Main Category</label>
                    <select id="category_id" name="category_id" class="form-control">
                        <option selected disabled>Choose option</option>
                        @foreach($mainCategories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('category_id')
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