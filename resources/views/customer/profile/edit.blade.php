@extends('customer.layouts.app') <!-- Ensure you have a layout for customers -->
@section('title', 'Customer Dashboard')
@section('content')

    <main class="container py-5">
        <!-- Dashboard Heading -->
        <div class="mb-4">
            <h1 class="display-5 fw-bold">Profile Information</h1>
            <p class="text-muted mt-1s">Update your profile...</p>
        </div>

        <!-- Profile Edit Section -->
        <div class="card shadow-sm p-4 mt-4">
            <div class="card-body">

                <!-- Profile Information Form -->
                <h4 class="mb-4">Update Profile Information</h4>
                @include('customer.profile.partials.update-profile-information-form')

                <!-- Password Update Section -->
                <h4 class="mb-4 mt-5">Change Password</h4>
                @include('customer.profile.partials.update-password-form')

                {{-- <!-- Account Deletion Section -->
                <h4 class="mb-4 mt-5">Delete Account</h4>
                @include('customer.profile.partials.delete-user-form') --}}

            </div>
        </div>
    </main>

@endsection
@section('scripts')
@endsection
