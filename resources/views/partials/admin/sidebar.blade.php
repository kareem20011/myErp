<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route( 'dashboard' ) }}" class="brand-link">
    <img src="{{ asset( 'assets/images/logo/white.png' ) }}" alt="AdminLTE Logo" class="brand-image "
      style="opacity: .8">
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if(Auth::user()->hasMedia('images'))
        <img class="img-circle elevation-2" src="{{ Auth::user()->getFirstMediaUrl('images') }}" alt="Avatar" width="50">
        @else
        <img class="img-circle elevation-2" src="{{ asset( 'assets/images/avatar.png' ) }}" alt="Avatar" width="50">
        @endif
      </div>
      <div class="info">
        <a href="{{ route( 'profile.show' ) }}" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Admin pages -->

        @if(session('is_admin'))


        <!-- Tenants -->
        <li class="nav-item">
          <a href="{{ route( 'admin.tenants.index' ) }}" class="nav-link {{ Route::is('admin.tenants.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-building"></i>
            <p>
              Tenants
            </p>
          </a>
        </li>


        @endif

        <!-- ./Admin pages -->

        <!-- Dashboard -->

        <!-- Users and Permissions -->
        @if(session('tenant_id') != null && has_permission('view', 'users'))
        <li class="nav-header">Users & Permissions</li>

        <!-- Roles and permissions -->
        @if(session('tenant_id') != null && has_permission('view', 'roles') || has_permission('view', 'permissions'))
        <li class="nav-item has-treeview {{ Route::is('roles.*') || Route::is('permissions.*') ? 'menu-open' : '' }}">
          <a class="nav-link {{ Route::is('roles.*') || Route::is('permissions.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tag"></i>
            <p style="cursor: pointer;">
              Roles & Permissions
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <!-- Roles -->
            @if(session('tenant_id') != null && has_permission('view', 'roles'))
            <li class="nav-item">
              <a href="{{ route( 'roles.index' ) }}" class="nav-link {{ Route::is('roles.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Roles</p>
              </a>
            </li>
            @endif
            <!-- ./Roles -->

            <!-- permissions -->
            @if(session('tenant_id') != null && has_permission('view', 'permissions'))
            <li class="nav-item">
              <a href="{{ route( 'permissions.index' ) }}" class="nav-link {{ Route::is('permissions.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Permissions</p>
              </a>
            </li>
            @endif
            <!-- ./permissions -->

          </ul>
        </li>
        @endif
        <!-- ./Roles and permissions -->


        <!-- User -->
        <li class="nav-item">
          <a href="{{ route( 'users.index' ) }}" class="nav-link {{ Route::is('users.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p style="cursor: pointer;">
              Users
            </p>
          </a>
        </li>
        <!-- ./User -->

        @endif
        <!-- ./Users and Permissions -->

        <!-- Inventory -->
        @if(session('tenant_id') != null &&
        (has_permission('view', 'suppliers') ||
        has_permission('view', 'categories') ||
        has_permission('view', 'subcategories') ||
        has_permission('view', 'products') ||
        has_permission('view', 'inventoryLogs') ||
        has_permission('view', 'LowStockNotification')))
        <li class="nav-header">Inventory</li>

        <li class="nav-item has-treeview {{ Request::is('dashboard/inventory*') ? 'menu-open' : '' }}">
          <a class="nav-link {{ Request::is('dashboard/inventory*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-boxes"></i>
            <p style="cursor: pointer;">
              Inventory
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            @if(session('tenant_id') != null && has_permission('view', 'suppliers'))
            <li class="nav-item">
              <a href="{{ route('suppliers.index') }}" class="nav-link {{ Route::is('suppliers.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Suppliers</p>
              </a>
            </li>
            @endif

            @if(session('tenant_id') != null && has_permission('view', 'categories'))
            <li class="nav-item">
              <a href="{{ route( 'categories.index' ) }}" class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Categories</p>
              </a>
            </li>
            @endif

            @if(session('tenant_id') != null && has_permission('view', 'subcategories'))
            <li class="nav-item">
              <a href="{{ route( 'subcategories.index' ) }}" class="nav-link {{ Route::is('subcategories.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Subcategories</p>
              </a>
            </li>
            @endif

            @if(session('tenant_id') != null && has_permission('view', 'products'))
            <li class="nav-item">
              <a href="{{ route( 'products.index' ) }}" class="nav-link {{ Route::is('products.*') || Route::is( 'inventory.logs.edit' ) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Products</p>
              </a>
            </li>
            @endif

            @if(session('tenant_id') != null && has_permission('view', 'inventoryLogs'))
            <li class="nav-item">
              <a href="{{ route( 'inventory.logs.index' ) }}" class="nav-link {{ Route::is('inventory.logs.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Inventory logs</p>
              </a>
            </li>
            @endif

            @if(session('tenant_id') != null && has_permission('view', 'LowStockNotification'))
            <li class="nav-item">
              <a href="{{ route( 'low.stock.index' ) }}" class="nav-link {{ Route::is('low.stock.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Stock Notifications</p>
              </a>
            </li>
            @endif

          </ul>
        </li>
        @endif
        <!-- ./Inventory -->

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>