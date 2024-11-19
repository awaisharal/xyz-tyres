@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')


<!doctype html>
<html lang="en">

  <body class="fixed-top-navbar top-nav  ">
    <!-- loader Start -->
    {{-- <div id="loading">
          <div id="loading-center">
          </div>
    </div> --}}
    <!-- loader END -->

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
                        {{-- <div class="float-sm-right">
                            <a href="{{ route('services.create') }}">
                               <button class="btn btn-primary d-flex justify-content-center text-center position-relative">
                                Add
                                <i class="ri-add-line"></i>
                               </button>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
       
    </div>
 </body>
</html>
