@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')

<!doctype html>
<html lang="en">
  <body class="fixed-top-navbar top-nav">
    <!-- Loader Start -->
    <div id="loading" style="position: fixed; width: 100%; height: 100%; background: white; z-index: 9999;">
        <div id="loading-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <!-- Loader END -->

    <div class="content-page">
        <div class="content-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="navbar-breadcrumb">
                                <h1 class="mb-1">Dashboard</h1>
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
        </div>
    </div>

    <!-- Remove loader on page load -->
    <script>
        window.addEventListener('load', function () {
            document.getElementById('loading').style.display = 'none';
        });
    </script>
  </body>
</html>
