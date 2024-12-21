@extends('customer.layouts.app')
@section('title', 'Payments')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Payments</h1>
        <p class="text-muted mt-1">View all payments you made</p>
    </div>

    <!-- Search Box -->
    <div class="row justify-content-end align-items-center flex-grow-1">
        <div class="col-md-4 mb-3 mb-sm-0">
            <form action="{{ url()->current() }}" method="GET">
                <div class="input-group input-group-merge input-group-flush">
                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                        placeholder="Search by Company, Service, Status, or Date" aria-label="Search"
                        value="{{ request('search') }}" required>
                </div>
            </form>
        </div>
    </div>
    <br>

    @if($payments->isEmpty())
        <p>No payments found.</p>
    @else
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Service</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->appointment->service->user->company ?? 'N/A' }}</td>
                                    <td>{{ $payment->appointment->service->title ?? 'N/A' }}</td>
                                    <td>${{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->appointment->date)->format('d M Y') }}</td>
                                    <td>
                                        <span class="{{ $payment->payment_status === 'PAID' ? 'text-success' : 'text-danger' }}">
                                            {{ $payment->payment_status }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
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
