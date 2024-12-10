@extends('layouts.admin')
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
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route( 'dashboard' ) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ $user->getFirstMediaUrl( 'images' ) }}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $user->name }}</h3>

                            @if(isset($user->role->name))
                            <p class="text-muted text-center">{{ $user->role->name }}</p>
                            @endif

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Name</b> <a class="float-right">{{ $user->name }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right">{{ $user->phone }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Birthdate</b> <a class="float-right">{{ $user->day }} / {{ $user->month }} / {{ $user->year }}</a>
                                </li>
                                @if(isset($user->role->name))
                                <li class="list-group-item">
                                    <b>Role</b> <a class="float-right">{{ $user->role->name }}</a>
                                </li>
                                @endif
                                <li class="list-group-item">
                                    <b>Status</b> <a class="float-right">{{ $user->status == '1' ? 'Active' : 'Disable' }}</a>
                                </li>
                            </ul>

                            <a href="{{ route( 'profile.edit' ) }}" class="btn btn-primary btn-block"><b>Edit</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
            </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection