<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'ERP System')</title>
    @include('partials.admin.header')

    <!-- Scripts -->
    @include('partials.admin.scripts')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <!-- wrapper -->
    <div class="wrapper">
        @include('partials.admin.nav')

        @include('partials.admin.sidebar')

        @yield('admin.content')

        @include('partials.admin.footer')

        @include('partials.DeleteConfirmationModal')
    </div>
    <!-- ./wrapper -->
</body>

</html>