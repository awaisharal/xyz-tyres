@extends('shopkeeper.layouts.app')
@section('title', 'Customers')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Customers</h1>
        <p class="text-muted mt-1">Manage your Customers</p>
    </div>

    @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @elseif(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if($customers->isEmpty())
        <p>No customers yet.</p>
    @else
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Number of Appointments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customerId => $appointments)
                                @php
                                    $customer = $appointments->first()->customer; // Get the customer details
                                    $phone = $appointments->first()->phone; // Fetch phone number from the appointment
                                    $appointmentCount = $appointments->count(); // Count total appointments for this customer
                                @endphp
                                <tr>
                                    <td>{{ $customer->name ?? 'N/A' }}</td>
                                    <td>{{ $customer->email ?? 'N/A' }}</td>
                                    <td>{{ $phone ?? 'N/A' }}</td>
                                    <td>{{ $appointmentCount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</main>
@endsection
