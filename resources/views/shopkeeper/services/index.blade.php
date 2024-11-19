@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')


<!doctype html>
<html lang="en">

  <body class="fixed-top-navbar top-nav  ">
    <!-- loader Start -->
    <div id="loading">
          <div id="loading-center">
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
                            <a href="{{ route('services.create') }}" class="btn btn-primary pr-5 position-relative" style="height: 40px;">
                                Add <span class="event-add-btn" style="height: 40px;">
                                    <i class="ri-add-line"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <div class="container">
        <div class="row">
            <div class="col-lg-12">                
                <div class="event-content">
                    <div id="event1" class="tab-pane fade active show">
                        <div class="row"> 
                            @foreach ($services as $service)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card card-block card-stretch card-height">
                                    <!-- Service Image -->
                                    <img 
                                        src="{{ asset('storage/' . $service->image) }}" 
                                        alt="{{ $service->title }}" 
                                        class="card-img-top rounded-top" 
                                        style="height: 200px; object-fit: cover;"
                                    >
                        
                                    <div class="card-body rounded event-detail event-detail-danger">
                                        <div class="d-flex flex-column">
                                            <!-- Title -->
                                            <h4 class="mb-2">{{ $service->title }}</h4>
                        
                                            <!-- Description -->
                                            {{-- <p class="card-description mb-3">{{ Str::limit($service->description, 100) }}</p> --}}
                        
                                            <!-- Price -->
                                            <p class="text-danger font-weight-500 mb-2">
                                                <i class="las la-tag pr-2"></i>Price: ${{ number_format($service->price, 2) }}
                                            </p>
                        
                                            <!-- Duration -->
                                            <p class="text-muted mb-3">
                                                <i class="las la-clock pr-2"></i>Duration: {{ $service->duration }} days
                                            </p>
                        
                                            <!-- First Reminder -->
                                            {{-- @if ($service->first_reminder_datetime || $service->first_reminder_message)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>
                                                        <i class="las la-bell pr-2"></i>
                                                        1st Reminder: 
                                                        {{ $service->first_reminder_datetime ? \Carbon\Carbon::parse($service->first_reminder_datetime)->format('d M Y, h:i A') : 'Not Set' }}
                                                    </span>
                                                    <span>Message: {{ $service->first_reminder_message ?? 'No Message' }}</span>
                                                </div>
                                            @endif --}}
                        
                                            <!-- Second Reminder -->
                                            {{-- @if ($service->second_reminder_datetime || $service->second_reminder_message)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>
                                                        <i class="las la-bell pr-2"></i>
                                                        2nd Reminder: 
                                                        {{ $service->second_reminder_datetime ? \Carbon\Carbon::parse($service->second_reminder_datetime)->format('d M Y, h:i A') : 'Not Set' }}
                                                    </span>
                                                    <span>Message: {{ $service->second_reminder_message ?? 'No Message' }}</span>
                                                </div>
                                            @endif --}}
                        
                                            <!-- Follow-up Reminder -->
                                            {{-- @if ($service->followup_reminder_datetime || $service->followup_reminder_message)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>
                                                        <i class="las la-bell pr-2"></i>
                                                        Follow-up Reminder: 
                                                        {{ $service->followup_reminder_datetime ? \Carbon\Carbon::parse($service->followup_reminder_datetime)->format('d M Y, h:i A') : 'Not Set' }}
                                                    </span>
                                                    <span>Message: {{ $service->followup_reminder_message ?? 'No Message' }}</span>
                                                </div>
                                            @endif --}}
                        
                                            <!-- Action Buttons -->
                                            <div class="d-flex align-items-center pt-3">
                                                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-primary mr-3 px-xl-3">
                                                    <i class="ri-pencil-line pr-1"></i>Edit
                                                </a>
                                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-xl-3">
                                                        <i class="ri-delete-bin-6-line pr-1"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
 </body>
</html>