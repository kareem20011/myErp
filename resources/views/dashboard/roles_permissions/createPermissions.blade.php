@extends('layouts.admin')
@section('title')
Create permissions
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
                    <h1>Create permission</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'permissions.index' ) }}">permissions</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="card card-primary m-3">
        <!-- form start -->
        <form action="{{ route( 'permissions.store' ) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="group">Choose group</label>
                    <select name="group" class="form-control" id="group">
                        <option selected disabled>Select option</option>
                        <option value="dashboard">dashboard</option>
                        <option value="users">Users</option>
                        <option value="roles">Roles</option>
                        <option value="permissions">Permissions</option>
                        <option value="suppliers">suppliers</option>
                        <option value="categories">categories</option>
                        <option value="subcategories">subcategories</option>
                        <option value="products">products</option>
                        <option value="inventoryLogs">inventoryLogs</option>
                        <option value="LowStockNotification">LowStockNotification</option>
                    </select>
                </div>
                @error('group')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label>Name</label>
                    <select multiple name="name[]" class="form-control">
                        <option value="view" @if(in_array('view', old('name', []))) selected @endif>view</option>
                        <option value="create" @if(in_array('create', old('name', []))) selected @endif>create</option>
                        <option value="update" @if(in_array('update', old('name', []))) selected @endif>update</option>
                        <option value="delete" @if(in_array('delete', old('name', []))) selected @endif>delete</option>
                    </select>
                </div>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
                @error('name.*')
                <p class="text-danger">The selected permission name is invalid.</p>
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