@extends('shopkeeper.layouts.app')
@section('title', 'Edit Profile')
@section('content')

<main class="d-flex justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h4>Profile</h4>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="name" class="title">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your full name..." value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="email" class="title">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email..." value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @include('shopkeeper.profile.partials.update-profile-information-form')
                        <div class="col-md-12 mb-3 text-right">
                            <button class="btn btn-dark py-1 px-3">
                                Save Profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection
