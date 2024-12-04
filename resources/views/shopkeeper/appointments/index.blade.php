
@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Appointments</h1>
        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @elseif(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        
        
        @if($appointments->isEmpty())
        <p>No appointment requests received yet.</p>
        @else
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->customer->name }}</td>
                        <td>{{ $appointment->customer->email }}</td>
                        <td>{{ $appointment->service->title }}</td>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->time }}</td>
                        <td>
                            @if($appointment->payment_status == 1)
                                <span class="text-success">Paid</span>
                            @else
                                <span class="text-danger">Unpaid</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>
</main>





@endsection
