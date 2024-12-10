<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'ERP System')</title>
    @include('partials.app.header')
</head>
<body>
    @include('partials.app.sidebar')
    <main>
        @yield('app.content')
    </main>
    @include('partials.app.footer')
</body>
</html>
