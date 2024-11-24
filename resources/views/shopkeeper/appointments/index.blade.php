@extends('shopkeeper.layouts.app')
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
    <!-- loader END -->

    <div class="content-page">
        
        <div class="container">
            <br>

            <h1>My Appointments</h1>
            <br>



@if($appointments->isEmpty())
        <p>No appointment requests received yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    {{-- <th>Action</th> --}}
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
                        {{-- <td>
                            @if($appointment->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($appointment->status == 'confirmed')
                                <span class="badge badge-success">Confirmed</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td> --}}
                        <td>Pending</td>
                        {{-- <td>
                            @if($appointment->status == 'pending')
                                <form action="{{ route('shopkeeper.appointment.update', $appointment->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="status" value="confirmed" class="btn btn-success btn-sm">Confirm</button>
                                    <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @else
                                <span class="text-muted">No Action</span>
                            @endif
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
        


    </div>
    
 </body>
</html>













    