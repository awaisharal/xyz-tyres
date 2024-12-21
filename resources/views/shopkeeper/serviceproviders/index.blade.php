@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Service Providers</h1>
        <p class="text-muted mt-1s">Manage your Service Providers</p>
    </div>
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
                        placeholder="Search by Name" aria-label="Search"
                        value="{{ request('search') }}" required>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="col-md-20">
        <div class="card">
            <div class="card-body">
                {{-- <form method="GET" action="{{ route('service-providers.index') }}" class="d-flex mb-4">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by name" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form> --}}

             

                <div class="d-flex justify-content-between">
                    <h4></h4>
                    <a href="{{ route('service-providers.create') }}" class="btn btn-lighter mx-2 d-flex align-items-center">
                        <i class="la la-plus me-2"></i> Add Service Provider
                    </a>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($serviceProviders as $provider)
                                <tr>
                                    <td>{{ $provider->name }}</td>
                                    <td>{{ $provider->email }}</td>
                                    <td>{{ $provider->phone }}</td>
                                    <td>{{ $provider->address }}</td>
                                    <td>
                                        <a class="dropdown-item" href="{{ route('service-providers.edit', $provider->id) }}">
                                            <i class="la la-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('service-providers.destroy', $provider->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="las la-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No service providers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
