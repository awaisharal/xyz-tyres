<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width">
    <title>@yield('title')</title>
    {{-- @php($favIcon = \App\Models\BusinessSetting::where(['key' => 'fav_icon'])->first()->value) --}}
    {{-- <link rel="shortcut icon" href="{{ asset('storage/app/public/shop') . '/' . $favIcon }}"> --}}
   

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/google-fonts.css">
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/vendor.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/vendor/icon-set/style.css">
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/theme.minc619.css?v=1.0">
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/bootstrap-select.min.css" />
    @stack('css_or_js')

    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/custom.css" />

    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/toastr.css">
    @yield('extra_css')
</head>

<body class="footer-offset">

    <div class="direction-toggle">
        <i class="tio-settings"></i>
        <span></span>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="loading" class="d-none">
                    <div class="loader-img">
                        <img width="200" src="{{ asset('public/assets/admin/img/loader.gif') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.admin.partials._header')
    @include('admin.layouts.admin.partials._sidebar')
    <main id="content" role="main" class="main pointer-event">
        @yield('content')
        @include('admin.layouts.admin.partials._footer')
        <div class="modal fade" id="popup-modal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <h2 class="title-new-order">
                                        <i class="tio-shopping-cart-outlined"></i>
                                        please check
                                    </h2>
                                    <hr>
                                    <button id="checkOrderBtn"
                                        class="btn btn-primary">let me check</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script src="{{ asset('assets/admin') }}/js/custom.js"></script>
    @stack('script')
    <script src="{{ asset('assets/admin') }}/js/vendor.min.js"></script>
    <script src="{{ asset('assets/admin') }}/js/theme.min.js"></script>
    <script src="{{ asset('assets/admin') }}/js/sweet_alert.js"></script>
    <script src="{{ asset('assets/admin') }}/js/toastr.js"></script>
    <script src="{{ asset('assets/admin') }}/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('assets/admin') }}/js/ck-editor.js"></script>
    @yield('extra_js')
    {{-- {!! Toastr::message() !!} --}}

    {{-- @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', Error, {
                    CloseButton: true,
                    ProgressBar: true
                });
            @endforeach
        </script>
    @endif --}}
    <!-- Toggle Direction Init -->
    {{-- <script>
        "use strict";
        $(document).on('ready', function() {

            $('#checkOrderBtn').on('click', function() {
                check_order();
            });

            $(".direction-toggle").on("click", function() {
                setDirection(localStorage.getItem("direction"));
            });

            function setDirection(direction) {
                if (direction == "rtl") {
                    localStorage.setItem("direction", "ltr");
                    $("html").attr('dir', 'ltr');
                    $(".direction-toggle").find('span').text('Toggle RTL')
                } else {
                    localStorage.setItem("direction", "rtl");
                    $("html").attr('dir', 'rtl');
                    $(".direction-toggle").find('span').text('Toggle LTR')
                }
            }

            if (localStorage.getItem("direction") == "rtl") {
                $("html").attr('dir', "rtl");
                $(".direction-toggle").find('span').text('Toggle LTR')
            } else {
                $("html").attr('dir', "ltr");
                $(".direction-toggle").find('span').text('Toggle RTL')
            }

        })

        $(document).ready(function() {
            if ($(".navbar-vertical-content li.active").length) {
                $('.navbar-vertical-content').animate({
                    scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
                }, 10);
            }
        });
    </script> --}}
    <script src="{{ asset('assets/admin') }}/js/app-page.js"></script>

    @stack('script_2')
    <audio id="myAudio">
        <source src="{{ asset('assets/admin/sound/notification.mp3') }}" type="audio/mpeg">
    </audio>

</body>

</html>
