<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    @if(session('tenant_id') && has_permission('view', 'dashboard'))
    <li class="nav-item d-none d-sm-inline-block {{ Route::is('dashboard') ? 'active' : '' }}">
      <a href="{{ route( 'dashboard' ) }}" class="nav-link">Home</a>
    </li>
    @endif

    @if(session('tenant_id') && has_permission('view', 'pos'))
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route( 'pos.home' ) }}" class="nav-link">POS</a>
    </li>
    @endif
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      
      <form action="{{ route('logout') }}" method="post">
        @csrf
      <button class="nav-link bg-transparent border-0" type="submit">
        <i class="fas fa-sign-out-alt"></i>
      </button>
      </form>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
