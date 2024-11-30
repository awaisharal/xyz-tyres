@extends('shopkeeper.layouts.app')
@section('title', 'Add Service Provider')
@section('content')

<main class="d-flex justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h4>
                    <a href="{{ route('service-providers.index') }}">
                        <i class="la la-arrow-left"></i>
                    </a>
                    &nbsp; Add Service Provider
                </h4>

                <form action="{{ route('service-providers.store') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="form-group">
                        <label for="name">Service Provider Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter service provider name..." value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email..." value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter phone number..." value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control" placeholder="Enter address..." rows="4">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-dark w-100 py-2">Add Service Provider</button>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection
