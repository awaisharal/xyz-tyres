
@extends('customer.layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Appointments</h1>

        <div class="row justify-content-end align-items-center flex-grow-1">
            <div class="col-md-4 mb-3 mb-sm-0">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="input-group input-group-merge input-group-flush">
                        <div class="input-group-prepend">
                            {{-- <div class="input-group-text">
                                <i class="tio-search"></i>
                            </div> --}}
                        </div>
                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                            placeholder="Search by Service, Customer, Phone, Date" aria-label="Search"
                            value="{{ request('search') }}" required>
                    </div>
                </form>
            </div>
        </div>
        
        @if($appointments->isEmpty())
        <p>No appointment! </p>
        @else

        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Service</th>
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
                        <td>{{ $appointment->service->user->company }}</td>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->time }}</td>
                        <td>
                            @if($appointment->payment_status ==='PAID')
                                <span class="text-success">$$$</span>
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

<script>
        document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('datatableSearch_');
        var searchForm = document.getElementById('searchForm');
        var isSearching = {{ request('search') ? 'true' : 'false' }};

        searchInput.addEventListener('input', function() {
            if (searchInput.value === '' && isSearching) {
                window.location.href = "{{ url()->current() }}";
            }
        });
        searchForm.addEventListener('submit', function() {
            searchInput.value = searchInput.value.replace(/-/g, '');
            isSearching = true;
        });
    });
</script>



@endsection
