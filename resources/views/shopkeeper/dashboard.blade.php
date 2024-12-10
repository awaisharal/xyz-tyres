@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Dashboard</h1>
        <p class="text-muted">View your account statistics</p>
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

        <!-- Free Appointments -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Free Appointments</h5>
                    <h2 class="card-text">{{ $freeAppointments }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Services Listed -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Services</h5>
                    <h2 class="card-text">{{ $totalServicesListed }}</h2>
                </div>
            </div>
        </div>

        <!-- Most Booked Service -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Most Booked Service</h5>
                    <p class="card-text">
                        {{ $mostBookedService ? $mostBookedService->title : 'No services booked yet' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Sales Card -->
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Sales</h5>
                        <select id="sales-period" class="form-select w-auto">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly" selected>Monthly</option>
                        </select>
                    </div>
                    <h2 id="sales-amount" class="card-text mt-3">${{ $sales['monthly'] }}</h2>
                </div>
            </div>
        </div>

        
        
    </div>
</main>
@endsection

@section('scripts')
<!-- Add Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.getElementById('sales-period').addEventListener('change', function () {
        const period = this.value;
        fetch(`{{ route('shopkeeper.sales') }}?period=${period}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('sales-amount').textContent = `$${data.sales}`;
            })
            .catch(error => console.error('Error fetching sales data:', error));
    });
</script>
@endsection
