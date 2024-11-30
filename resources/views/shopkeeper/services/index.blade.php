@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="container py-5">
    <div class="mb-4">
        <h1 class="display-5 fw-bold">My Services</h1>
        <p class="text-muted mt-1s">Manage and organize your service offerings</p>
    </div>

    <!-- Search and Add Service -->
    <div class="d-flex mb-4">
        <div class="position-relative d-flex align-items-center flex-grow-1">
        <input type="text" class="form-control ps-5 bg-white" placeholder="Search services..." style="text-indent: 20px">
        <span class="position-absolute top-50 start-0 translate-middle-y mx-3 text-muted">
            <i class="las la-search"></i>
        </span>
        </div>
        <a href="{{route('services.create')}}"  class="btn btn-lighter mx-2 d-flex align-items-center">
        <i class="la la-plus me-2"></i> Add Service
        </a>
    </div>

    <!-- Services Grid -->
    @if(count($services) > 0)
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <!-- Service Card -->
        @foreach($services as $obj)
        <div class="col">
            <div class="card shadow-sm">
                <div class="position-relative card-heade" style="height: 250px;overflow:hidden;">
                    <img src="{{ $obj->image ? asset('assets/uploads/services/' . $obj->image) : asset('https://media.istockphoto.com/id/1452870348/vector/rocket-ship-icon-in-flat-style-spacecraft-takeoff-on-space-background-start-up-illustration.jpg?s=612x612&w=0&k=20&c=Ik4wg3D1NmtuebK88Bgb3CKwY7xx5SQ4RcZWKl38ydw=') }}" alt="Service" class="w-100" style="object-fit: cover!important; width: 100%;height: 100%;border-radius: 4px;">
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">
                            {{$obj->title}}
                        </h5>
                    </div>
                    <p class="card-text text-muted">
                        {{$obj->description}}
                    </p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="mb-0 fw600">${{number_format($obj->price, 2)}}</div>
                        <div class="mx-2"> - </div>
                        <div class="text-muted d-flex align-items-center fw500">
                            <i class="la la-clock me-1"></i> {{$obj->duration}} 
                        </div>
                    </div>
                    <div class="dropdown" style="float: right;">
                        <button class="btn btn-link text-dark" type="button" id="dropdownMenuButton{{$loop->index}}" data-toggle="dropdown" aria-expanded="false">
                            <i class="la la-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$loop->index}}">
                            <li>
                                <a class="dropdown-item" href="{{ route('services.edit', $obj->id) }}">
                                    <i class="la la-edit"></i> Edit
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('services.destroy', $obj->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="las la-trash"></i> Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- @endforeach --}}
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="d-flex justify-content-center w-10">
        <div class="text-center">
            <svg data-slot="icon" fill="none" stroke-width="1.5" width="100" height="100" stroke="#ccc" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"></path>
            </svg>
            <p class="text-muted">No records found!</p>
        </div>
    </div>
    @endif
</main>
@endsection
