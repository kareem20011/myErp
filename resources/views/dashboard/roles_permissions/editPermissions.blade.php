@extends('layouts.admin')
@section('title')
Edit permissions
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
                    <h1>Edit permission</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'permissions.index' ) }}">permissions</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="alert alert-warning mx-3">
        <h5>If you remove any permission it will remove from roles too!</h5>
    </div>

    <!-- Main content -->
    <div class="card card-primary m-3">
        <!-- form start -->
        <form action="{{ route( 'permissions.update' ) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">

                @foreach($permissionGroup as $group => $permissions)
                <div class="form-group">
                    <label for="group">Permission group</label>
                    <select name="group" class="form-control" id="group">
                        <option disabled>Select option</option>
                        <option value="dashboard" {{ $group == "dashboard" ? 'selected' : '' }}>dashboard</option>
                        <option value="users" {{ $group == "users" ? 'selected' : '' }}>Users</option>
                        <option value="roles" {{ $group == "roles" ? 'selected' : '' }}>Roles</option>
                        <option value="permissions" {{ $group == "permissions" ? 'selected' : '' }}>Permissions</option>
                        <option value="suppliers" {{ $group == "suppliers" ? 'selected' : '' }}>suppliers</option>
                    </select>
                </div>
                @error('group')
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label>Name</label>
                    <select multiple name="name[]" class="form-control">
                        <option value="view"
                            @if(in_array('view', $permissions->pluck('name')->toArray())) selected @endif>
                            view
                        </option>
                        <option value="create"
                            @if(in_array('create', $permissions->pluck('name')->toArray())) selected @endif>
                            create
                        </option>
                        <option value="update"
                            @if(in_array('update', $permissions->pluck('name')->toArray())) selected @endif>
                            update
                        </option>
                        <option value="delete"
                            @if(in_array('delete', $permissions->pluck('name')->toArray())) selected @endif>
                            delete
                        </option>
                    </select>
                </div>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
                @error('name.*')
                <p class="text-danger">The selected permission name is invalid.</p>
                @enderror

                @endforeach
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