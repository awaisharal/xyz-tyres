@extends('customer.layouts.app')
@section('title', 'Dashboard')


<!doctype html>
<html lang="en">

  <body class="fixed-top-navbar top-nav  ">
    <!-- loader Start -->
    <div id="loading" style="position: fixed; width: 100%; height: 100%; background: white; z-index: 9999;">
        <div id="loading-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <!-- loader END -->

    <div class="content-page">
        <div class="content-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="navbar-breadcrumb">
                                <h1 class="mb-1">Available Services</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-extra active" id="search-with-button">
                    <div class="d-flex flex-wrap align-items-center mb-4">
                        <div class="iq-search-bar search-device mb-0 pr-3">
                            <form action="#" class="searchbox">
                                <input type="text" class="text search-input" placeholder="Search...">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach ($services as $service)
                    <div class="col-lg-4 col-md-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body rounded event-detail event-detail-primary">
                                <div class="position-relative">
                                    <div class="text-center">
                                        <img
                                            src="{{ $service->image ? asset('assets/uploads/services/' . $service->image) : asset('assets/uploads/services/default-image.jpg') }}"
                                            alt="{{ $service->title }}"
                                            class="card-img-top rounded-top"
                                            style="height: 150px; width: 150px; object-fit: cover; max-width: 100%;"
                                        >
                                    </div>
                                    <div class="mt-3">
                                        <h4 class="mb-2 text-capitalize">{{ $service->title }}</h4>
                                        <p class="text-muted mb-3">{{ Str::limit($service->description, 100) }}</p>
                                        <p class="text-danger font-weight-500 mb-2">
                                            <i class="las la-tag pr-2"></i>Price: &dollar;{{ number_format($service->price, 2) }}
                                        </p>
                                        <p class="text-muted mb-3">
                                            <i class="las la-clock pr-2"></i>Duration: {{ $service->duration }} days
                                        </p>
                                        <p class="text-primary mb-3">
                                            <i class="las la-user pr-2"></i>Provided by: {{ $service->user->name ?? 'Unknown' }}
                                        </p>
                                        
                                        <a href="{{ route('customer.appointment.create', $service->id) }}" class="btn btn-primary rounded-pill mt-2">
                                            Get Service
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <script>
        window.addEventListener('load', function () {
            document.getElementById('loading').style.display = 'none';
        });
    </script>
 </body>
</html>
