
@extends('customer.layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Appointments</h1>
        
        
        @if($appointments->isEmpty())
        <p>No appointment! </p>
        @else
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Service Provier</th>
                    <th>Company</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->service->title }}</td>
                        <td>{{ $appointment->service->user->name }}</td>
                        <td>{{ $appointment->service->user->company }}</td>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->time }}</td>
                        <td>
                            @if($appointment->payment_status ==='PAID')
                                <span class="text-success">{{$appointment->payment_status}}</span>
                            @else
                                <span class="text-danger">{{$appointment->payment_status}}</span>
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
