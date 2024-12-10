<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <img src="{{ asset( 'assets/images/logo/white.png' ) }}" alt="AdminLTE Logo" class="brand-image" style="width: 50px;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse px-3" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Route::is('pos.home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pos.home') }}">Home</a>
            </li>

            <li class="nav-item {{ Route::is('pos.sales') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pos.sales') }}">Sales</a>
            </li>

            <li class="nav-item {{ Route::is('pos.orders*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pos.orders') }}">Orders</a>
            </li>

            <li class="nav-item {{ Route::is('pos.products*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pos.products.mainCategories') }}">Products</a>
            </li>

            <li class="nav-item {{ Route::is('pos.reports*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pos.reports') }}">Reports</a>
            </li>

            @if(session('tenant_id') != null && has_permission('view', 'dashboard'))
            <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            @endif
        </ul>
        <form action="{{ route('logout') }}" method="post" class="form-inline my-2 my-lg-0">
            @csrf
            <button class="nav-link bg-transparent border-0 text-white" type="submit">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
</nav>