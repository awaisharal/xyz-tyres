@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')
@section('content')

<main class="container py-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1 class="display-5 fw-bold">Dashboard</h1>
        <div>
            <select id="dashboard-period" class="form-control" onchange="changePeriod(this.value)">
                <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Today</option>
                <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Last 7 days</option>
                <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Last Month</option>
            </select>
        </div>
    </div>

    <div class="row g-4">
        <!-- Total Appointments -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Appointments</h5>
                    <h2 class="card-text">{{ $totalAppointments }}</h2>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Upcoming Appointments</h5>
                    <h2 class="card-text">{{ $upcomingAppointments }}</h2>
                </div>
            </div>
        </div>

        
        <!-- Sales Card -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Sales</h5>
                    <h2 class="card-text mt-3">${{ $sales }}</h2>
                </div>
            </div>
        </div>

        <!-- Most Booked Service -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Most Booked Service</h5>
                    <br>
                <p class="card-text text-success" style="font-size: 1.5rem;">
                    <strong>{{ $mostBookedService ? $mostBookedService->title : 'No services booked yet' }}</strong>
                </p>
                </div>
            </div>
        </div>

        {{-- <iframe src="http://127.0.0.1:8000/embed/{company_slug}" width="100%" 
        height="600" 
        frameborder="0" 
        style="border: 2px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 10px;"></iframe> --}}
        
    </div>
</main>
@endsection

@section('scripts')
<script>
    function changePeriod(period) {
        window.location.href = `{{ url('/') }}?period=${period}`;
    }
</script>
@endsection
