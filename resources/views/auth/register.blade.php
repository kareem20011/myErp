@extends('layouts.auth')
@section('auth.content')
<div class="register-box">
  <div class="register-logo">
    <p><b>ERP</b>system</p>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="{{ route( 'register' ) }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input name="name" type="text" class="form-control" placeholder="Full name" value="{{ old( 'name' ) }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        @error('name')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="input-group mb-3">
          <input name="email" type="email" class="form-control" placeholder="Email" value="{{ old( 'email' ) }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="input-group mb-3">
          <input name="phone" type="email" class="form-control" placeholder="Phone" value="{{ old( 'phone' ) }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @error('phone')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="input-group mb-3">
          <input name="day" type="email" class="form-control" placeholder="day" value="{{ old( 'day' ) }}">
          <input name="month" type="email" class="form-control" placeholder="month" value="{{ old( 'month' ) }}">
          <input name="year" type="email" class="form-control" placeholder="year" value="{{ old( 'year' ) }}">
        </div>
        @error('day')
        <span class="text-danger">{{ $message }}</span>
        @enderror
        @error('month')
        <span class="text-danger">{{ $message }}</span>
        @enderror
        @error('year')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="input-group mb-3">
          <input name="password_confirmation" type="password" class="form-control" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password_confirmation')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
          </div>
        </div>
      </form>

      <a href="{{ route( 'login' ) }}" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>

@endsection