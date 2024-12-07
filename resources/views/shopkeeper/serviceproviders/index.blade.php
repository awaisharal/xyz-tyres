@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Service Providers</h1>
        <p class="text-muted mt-1s">Manage your Service Providers</p>
    </div>

    <div class="col-md-20">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4></h4>
                    <a href="{{ route('service-providers.create') }}"  class="btn btn-lighter mx-2 d-flex align-items-center">
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
                                        <form action="{{ route('service-providers.destroy', $provider->id) }}" method="post">
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



