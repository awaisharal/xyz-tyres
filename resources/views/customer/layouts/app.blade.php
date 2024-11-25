<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="/" />
        <meta charset="utf-8" />
        <title>@yield('title', 'Dashboard')</title>
        <link rel="shortcut icon" href="/assets/images/favicon.ico" />
        <link rel="stylesheet" href="/assets/css/backend-plugin.min.css">
        <link rel="stylesheet" href="/assets/css/backend.css?v=1.0.1">
        <link rel="stylesheet" href="/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
        <link rel="stylesheet" href="/assets/vendor/remixicon/fonts/remixicon.css">
        @yield('head')
    </head>
    <body class="fixed-top-navbar ">

        {{-- Loader --}}
        <div id="loading" style="position: fixed; width: 100%; height: 100%; background: white; z-index: 9999;">
            <div id="loading-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        @include('customer.partials.header')

        <main class="mt-5 pt-5">
            @yield('content')
        </main>


        {{-- @include('shopkeeper.partials.footer') --}}


        <script src="/assets/js/backend-bundle.min.js"></script>
        <script src="/assets/js/customizer.js"></script>
        <script src="/assets/js/app.js"></script>
        <script>
            window.addEventListener('load', function () {
                document.getElementById('loading').style.display = 'none';
            });
        </script>
        @yield('scripts')
    </body>

</html>
