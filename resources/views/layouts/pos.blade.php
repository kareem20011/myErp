<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'ERP System')</title>
    @include('partials.admin.header')
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <!-- Scripts -->
    @include('partials.admin.scripts')
</head>

<body>
    @include('partials.pos.nav')

    <!-- content -->
    <div class="container">
        @yield('pos.content')
    </div>
    <!-- ./content -->
</body>

</html>