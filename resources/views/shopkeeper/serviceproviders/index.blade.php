@extends('shopkeeper.layouts.app')
@section('title', 'Service Providers')
@section('content')

<main class="d-flex justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4>Service Providers</h4>
                    <a href="{{ route('service-providers.create') }}" class="btn btn-dark">Add New Service Provider</a>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($serviceProviders as $provider)
                                <tr>
                                    <td>{{ $provider->name }}</td>
                                    <td>{{ $provider->email }}</td>
                                    <td>{{ $provider->phone }}</td>
                                    <td>
                                        <a href="{{ route('service-providers.edit', $provider->id) }}" class="btn btn-sm btn-info">Edit</a>
                                        <form action="{{ route('service-providers.destroy', $provider->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this service provider?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No service providers found.</td>
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
