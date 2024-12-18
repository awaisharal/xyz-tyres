<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/" />
    <meta charset="utf-8" />
    <title>Available Services</title>
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
    <link rel="stylesheet" href="/assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="/assets/css/backend.css?v=1.0.1">
    <link rel="stylesheet" href="/assets/css/toastr.css">
    <link rel="stylesheet" href="/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="/assets/vendor/remixicon/fonts/remixicon.css">
</head>

<body class="fixed-top-navbar">
    {{-- Loader --}}
    <div id="loading" style="position: fixed; width: 100%; height: 100%; background: white; z-index: 9999;">
        <div id="loading-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    {{-- @include('customer.partials.header') --}}

    <main class="mt-5 pt-5">
        <div class="container">
            <h3 >Services by <span style=" text-transform: uppercase;">{{ $user->company }}</span></h3>

            <br>
            @if(count($services) > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <!-- Service Card -->
                    @foreach($services as $service)
                        <div class="col">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">
                                            {{ $service->title }}
                                        </h5>
                                    </div>
                                    <p class="card-text text-muted">
                                        {{ $service->description }}
                                    </p>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mb-0 fw600">${{ number_format($service->price, 2) }}</div>
                                        <div class="mx-2"> - </div>
                                        <div class="text-muted d-flex align-items-center fw500">
                                            <i class="la la-clock me-1"></i> {{ $service->duration }} days
                                        </div>
                                    </div>
                                    <a href="{{ route('customer.appointment.create', ['company_slug' => $service->user->company_slug, 'service' => $service->id]) }}" 
                                       class="btn btn-outline-dark mx-2 d-flex align-items-center">
                                         Book Now
                                     </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="d-flex justify-content-center w-100">
                    <div class="text-center">
                        <svg fill="none" stroke-width="1.5" width="100" height="100" stroke="#ccc" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"></path>
                        </svg>
                        <p class="text-muted">No services available at the moment.</p>
                    </div>
                </div>
            @endif
        </div>
    </main>

    {{-- Footer (Optional) --}}
    {{-- @include('shopkeeper.partials.footer') --}}

    <script src="/assets/js/backend-bundle.min.js"></script>
    <script src="/assets/js/customizer.js"></script>
    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/toastr.js"></script>
    <script>
        window.addEventListener('load', function () {
            document.getElementById('loading').style.display = 'none';
        });
    </script>

    {!! Toastr::message() !!}

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', Error, {
                    CloseButton: true,
                    ProgressBar: true
                });
            @endforeach
        </script>
    @endif
</body>

</html>
