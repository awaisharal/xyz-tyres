@extends('customer.layouts.app')
@section('title', 'Create Appointment')
@section('content')

<main class="d-flex justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <div>
                    <h4>
                        <a href="{{ route('customer.services') }}">
                            <i class="la la-arrow-left"></i>
                        </a>
                        &nbsp;
                        Create Appointment
                    </h4>
                </div>
                <form action="{{ route('customer.appointment.store', $service->id) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="row">
                        <!-- Customer Name -->
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="customer_name">Customer Name</label>
                                <input 
                                    type="text" 
                                    name="customer_name" 
                                    id="customer_name" 
                                    class="form-control" 
                                    value="{{ old('customer_name', $customer->name) }}" 
                                    readonly 
                                    required>
                                @error('customer_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Customer Email -->
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="customer_email">Customer Email</label>
                                <input 
                                    type="email" 
                                    name="customer_email" 
                                    id="customer_email" 
                                    class="form-control" 
                                    value="{{ old('customer_email', $customer->email) }}" 
                                    readonly 
                                    required>
                                @error('customer_email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Appointment Date -->
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="date">Appointment Date</label>
                                <input 
                                    type="date" 
                                    name="date" 
                                    id="date" 
                                    class="form-control" 
                                    value="{{ old('date', now()->format('Y-m-d')) }}" 
                                    required>
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Appointment Time -->
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="time">Appointment Time</label>
                                <input 
                                    type="time" 
                                    name="time" 
                                    id="time" 
                                    class="form-control" 
                                    value="{{ old('time', now()->format('H:i')) }}" 
                                    required>
                                @error('time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Service -->
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="service">Service</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="service" 
                                    value="{{ $service->title }}" 
                                    readonly>
                                @error('service_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-dark w-100 py-2 d-flex align-items-center justify-content-center">
                                Create Appointment &nbsp;
                                <i class="la la-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection
@section('scripts')
<script>
    window.addEventListener('load', function () {
        document.getElementById('loading').style.display = 'none';
    });
</script>
@endsection
