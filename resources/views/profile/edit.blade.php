@extends('layouts.admin')
@section('admin.content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit profile</h1>
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
                        <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <input name="image" id="image" type="file" style="display: none;">
                                    <label for="image" style="cursor: pointer;">
                                        <img class="profile-user-img img-fluid img-circle" src="{{ $user->getFirstMediaUrl( 'images' ) }}" alt="User profile picture">
                                    </label>
                                </div>

                                <h3 class="profile-username text-center">{{ $user->name }}</h3>

                                @if(isset($user->role->name))
                                <p class="text-muted text-center"><b>Role:</b> {{ $user->role->name }}</p>
                                @endif

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <label for="name">Name</label>
                                        <input name="name" placeholder="Enter your name" value="{{ $user->name }}" id="name" type="text" class="form-control form-control-sm">
                                    </li>
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <li class="list-group-item">
                                        <label for="email">Email</label>
                                        <input name="email" placeholder="Enter your email" value="{{ $user->email }}" id="email" type="text" class="form-control form-control-sm">
                                    </li>
                                    @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <li class="list-group-item">
                                        <label for="phone">Phone</label>
                                        <input name="phone" placeholder="Enter your phone" value="{{ $user->phone }}" id="phone" type="text" class="form-control form-control-sm">
                                    </li>
                                    @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <li class="list-group-item">
                                        <label>Birthdate</label>
                                        <div class="input-group">
                                            <input name="day" placeholder="day" value="{{ $user->day }}" id="day" type="text" class="form-control form-control-sm">
                                            <input name="month" placeholder="month" value="{{ $user->month }}" id="month" type="text" class="form-control form-control-sm">
                                            <input name="year" placeholder="year" value="{{ $user->year }}" id="year" type="text" class="form-control form-control-sm">
                                        </div>
                                    </li>
                                    @error('day')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    @error('month')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    @error('year')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                    <li class="list-group-item">
                                        <div class="form-group">
                                            <label for="password">Old password</label>
                                            <input name="oldPassword" type="password" class="form-control" id="password" placeholder="Password">
                                        </div>
                                        @error('oldPassword')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                                        </div>
                                        @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror

                                        <div class="form-group">
                                            <label for="password_confirmation">Retype password</label>
                                            <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Retype password">
                                        </div>
                                        @error('password_confirmation')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </li>
                                </ul>

                                <button class="btn btn-primary btn-block"><b>Update</b></button>
                            </div>
                        </form>
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