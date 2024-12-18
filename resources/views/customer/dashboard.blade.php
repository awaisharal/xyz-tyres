@extends('customer.layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Dashboard</h1>
        <p class="text-muted mt-1s">View your account statistics</p>
    </div>
    <iframe src="http://localhost:8000/embed/shop" width="100%" height="600" frameborder="0" style="border: 2px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 10px;"></iframe>
</main>
@endsection
