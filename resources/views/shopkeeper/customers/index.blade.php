@extends('shopkeeper.layouts.app')
@section('title', 'Customers')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Customers</h1>
        <p class="text-muted mt-1">Manage your Customers</p>
    </div>

    {{-- Search Form --}}
    <div class="row justify-content-end align-items-center flex-grow-1">
        <div class="col-md-4 mb-3 mb-sm-0">
            <form action="{{ url()->current() }}" method="GET">
                <div class="input-group input-group-merge input-group-flush">
                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                        placeholder="Search by Name, Email, or Phone" aria-label="Search"
                        value="{{ request('search') }}" required>
                </div>
            </form>
        </div>
    </div>
    <br>

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
        <p>No customers found.</p>
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
                                @foreach ($customers as $data)
                                    <tr>
                                        <td>{{ $data['customer']->name ?? 'N/A' }}</td>
                                        <td>{{ $data['customer']->email ?? 'N/A' }}</td>
                                        <td>{{ $data['phone'] ?? 'N/A' }}</td>
                                        <td>{{ $data['appointment_count'] }}</td>
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
