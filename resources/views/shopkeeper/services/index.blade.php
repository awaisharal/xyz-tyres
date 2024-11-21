@extends('shopkeeper.layouts.app')
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
                                <h1 class="mb-1">My Services</h1>
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
                        <div class="float-sm-right">
                            <a href="{{ route('services.create') }}">
                               <button class="btn btn-primary d-flex justify-content-center text-center position-relative">
                                Add
                                <i class="ri-add-line"></i>
                               </button>
                            </a>
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
                                    src="{{ $service->image ? asset('storage/' . $service->image) : asset('storage/default-image.jpg') }}"
                                    alt="{{ $service->title }}"
                                    class="card-img-top rounded-top"
                                    style="height: 150px; width: 150px; object-fit: cover; max-width: 100%;"
                                >
                            </div>
            
                            
                            <div class="card-header-toolbar mt-1 position-absolute" style="top: 10px; right: 10px;">
                                <div class="dropdown">
                                    <span class="dropdown-toggle" id="dropdownMenuButton4" data-toggle="dropdown">
                                        <i class="ri-more-2-fill"></i>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton4">
                                        <a class="dropdown-item" href="{{ route('services.edit', $service->id) }}">
                                            <i class="ri-pencil-line mr-3"></i>Edit
                                        </a>
                                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">
                                                <i class="ri-delete-bin-6-line mr-3"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h4 class="mb-2 mr-4">{{ $service->title }}</h4>
                                <p class="text-muted mb-3">
                                    {{ $service->description }}
                                </p>
                                <p class="text-danger font-weight-500 mb-2">
                                    <i class="las la-tag pr-2"></i>Price: ${{ number_format($service->price, 2) }}
                                </p>
                                <p class="text-muted mb-3">
                                    <i class="las la-clock pr-2"></i>Duration: {{ $service->duration }} days
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
             @endforeach
        </div>
    </div>
    <script>
        window.addEventListener('load', function () {
            document.getElementById('loading').style.display = 'none';
        });
    </script>
 </body>
</html>
