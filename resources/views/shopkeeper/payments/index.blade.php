@extends('shopkeeper.layouts.app')
@section('title', 'Payments')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Payments</h1>
        <p class="text-muted mt-1">View all payments made by your customers</p>
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

    @if($payments->isEmpty())
        <p>No payments yet.</p>
    @else
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Service</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                @php
                                    $customer = $payment->appointment->customer; // Get the customer
                                @endphp
                                <tr>
                                    <td>{{ $customer->name ?? 'N/A' }}</td>
                                    <td>{{ $payment->service_name ?? 'N/A' }}</td>
                                    <td>${{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->appointment_date)->format('d M Y') }}</td>
                                    <td><span class="text-success">{{ $payment->payment_status }}</span></td>
                                    <td>{{ $payment->transaction_id }}</td>
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
