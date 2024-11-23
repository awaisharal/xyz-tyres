{{-- <div class="container">
    <h1>Book Appointment for {{ $service->title }}</h1>
    <form action="{{ route('customer.appointment.store', $service->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="customer_name">Your Name</label>
            <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name', $customer->name) }}" required>
        </div>
        <div class="form-group">
            <label for="customer_email">Your Email</label>
            <input type="email" name="customer_email" id="customer_email" class="form-control" value="{{ old('customer_email', $customer->email) }}" required>
        </div>
        <div class="form-group">
            <label for="date">Appointment Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="time">Appointment Time</label>
            <input type="time" name="time" id="time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Book Appointment</button>
    </form>
</div> --}}


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

    <div class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="py-4 border-bottom">
                        <div class="float-left">
                            <a href="{{ route('customer.services') }}" class="badge bg-white back-arrow">
                                <i class="las la-angle-left"></i>
                            </a>
                        </div>
                        <div class="form-title text-center">
                            <h3>Create Appointment</h3>
                        </div>
    
                        <form action="{{ route('customer.appointment.store', $service->id) }}" method="POST">
                            @csrf
                            <div class="col-lg-12">
                                <div class="card card-block card-stretch create-workform">
                                    <div class="card-body p-5">
                                        <div class="row">
                                            
                                            <!-- Customer Name -->
                                        <div class="col-lg-6 mb-4">
                                            <label class="title">Customer Name</label>
                                            <input 
                                                type="text" 
                                                name="customer_name" 
                                                class="form-control" 
                                                placeholder="Enter customer name" 
                                                value="{{ old('customer_name', $customer->name) }}" 
                                                readonly 
                                                required
                                            >
                                            @error('customer_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Customer Email -->
                                        <div class="col-lg-6 mb-4">
                                            <label class="title">Customer Email</label>
                                            <input 
                                                type="email" 
                                                name="customer_email" 
                                                class="form-control" 
                                                placeholder="Enter customer email..." 
                                                value="{{ old('customer_email', $customer->email) }}" 
                                                readonly 
                                                required
                                            >
                                            @error('customer_email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

    
                                            <!-- Appointment Date -->
                                            <div class="col-lg-6 mb-4">
                                                <label class="title">Appointment Date</label>
                                                <input 
                                                    type="date" 
                                                    name="date" 
                                                    class="form-control" 
                                                    value="{{ old('date', now()->format('Y-m-d')) }}" 
                                                    required
                                                >
                                                @error('date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Appointment Time -->
                                            <div class="col-lg-6 mb-4">
                                                <label class="title">Appointment Time</label>
                                                <input 
                                                    type="time" 
                                                    name="time" 
                                                    class="form-control" 
                                                    value="{{ old('time', now()->format('H:i')) }}" 
                                                    required
                                                >
                                                @error('time')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-4">
                                                <label class="title">Service</label>
                                                <input type="text" class="form-control" value="{{ $service->title }}" readonly>
                                                @error('service_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

    
                                            <!-- Submit Button -->
                                            <div class="col-lg-12 mt-4">
                                                <div class="d-flex flex-wrap align-items-center justify-content-center">
                                                    <button type="submit" class="btn btn-outline-primary">Create Appointment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

