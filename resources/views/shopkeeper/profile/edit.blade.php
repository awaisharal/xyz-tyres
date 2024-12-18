@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')
@section('content')
<style>
    #iframeLink::selection {
       background-color: transparent; 
   }
</style>

<main class="container py-5">
    <!-- Dashboard Heading -->
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Profile Information</h1>
        <p class="text-muted mt-1s">Update your profile...</p>
    </div>

    <!-- Profile Edit Section -->
    <div class="card shadow-sm p-4 mt-4">
        <div class="card-body">

            <h4 class="mb-4">Update Profile Information</h4>
            @include('shopkeeper.profile.partials.update-profile-information-form')

            <h4 class="mb-4">Update Shop Schedule</h4>
            @include('shopkeeper.profile.partials.shop-schedule')

             <!-- Iframe Link Copy Section -->
            <h4 class="mb-4 mt-5">Share Your Booking Widget</h4>
            <div class="input-group mb-3 position-relative">
                {{-- <input type="text" class="form-control border-none text-black fw-bolder" style="font-size: 15px;" id="iframeLink" value="{{ url('/embed/' . $user->company_slug) }}" readonly> --}}
                <input type="text" 
                class="form-control border-none text-black fw-bolder" 
                style="font-size: 15px;" 
                id="iframeLink" 
                value='<iframe src="{{ url('/embed/' . $user->company_slug) }}" width="100%" height="600" frameborder="0" style="border: 2px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 10px;"></iframe>' 
                readonly>

                <button style="border:none" onclick="copyToClipboard('iframeLink', this)">
                    <i class="las la-paste" style="font-size: 22px;"></i>
                </button>
                <!-- Tooltip container -->
                <div class="tooltip-copy text-black rounded-pill px-1 position-absolute" style="top: -30px; left: 95%; transform: translateX(-13%); display: none; background-color: #E9ECEF">
                    Copied!
                </div>
            </div>

            <!-- Password Update Section -->
            <h4 class="mb-4 mt-5">Change Password</h4>
            @include('shopkeeper.profile.partials.update-password-form')

            <!-- Account Deletion Section -->
            <h4 class="mb-4 mt-5">Delete Account</h4>
            @include('shopkeeper.profile.partials.delete-user-form')


        </div>
    </div>

</main>

@endsection
@section('scripts')
<script>
   function copyToClipboard(inputId, button) {
        // Get the input field and button elements
        var copyText = document.getElementById(inputId);
        
        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        document.execCommand("copy");

        // Show tooltip indicating the text was copied
        var tooltip = button.nextElementSibling;
        tooltip.style.display = 'block';
        
        // Hide the tooltip after 2 seconds
        setTimeout(function() {
            tooltip.style.display = 'none';
        }, 2000);
    }
</script>
@endsection
