
@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Appointments</h1>
        
        
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
                        <td>{{ $appointment->customer_name }}</td>
                        <td>{{ $appointment->customer_email }}</td>
                        <td>{{ $appointment->service->title }}</td>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->time }}</td>
                        
                        <td>Pending</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>
</main>





@endsection
