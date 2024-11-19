<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/" />
    <meta charset="utf-8" />
    <title>@yield('title', 'Shopkeeper Dashboard')</title>
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
    <link rel="stylesheet" href="/assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="/assets/css/backend.css?v=1.0.1">
    <link rel="stylesheet" href="/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="/assets/vendor/remixicon/fonts/remixicon.css">
    @yield('head')
</head>
<body>
        @include('shopkeeper.partials.header')

    <main>
        @yield('content')
    </main>

    <!-- Include Footer -->
    @include('shopkeeper.partials.footer')

    <!-- Scripts -->
    <script src="/assets/js/backend-bundle.min.js"></script>
    <script src="/assets/js/customizer.js"></script>
    <script src="/assets/js/app.js"></script>
    @yield('scripts')
</body>
</html>
