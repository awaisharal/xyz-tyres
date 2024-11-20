@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')


<!doctype html>
<html lang="en">

  <body class="fixed-top-navbar top-nav  ">
    <!-- loader Start -->
    <div id="loading" style="position: fixed; width: 100%; height: 100%; background: white; z-index: 9999;">
        <div id="loading-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <div class="content-page">
        <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="py-4 border-bottom">
                            <div class="float-left"><a href="{{ route('services.index') }}" class="badge bg-white back-arrow"><i class="las la-angle-left"></i></a></div>
                                <div class="form-title text-center">
                                    <h3>Add Service</h3>
                                </div>
                                <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-lg-12">
                                        <div class="card card-block card-stretch create-workform">
                                            <div class="card-body p-5">
                                                <div class="row">
                                                    <!-- Title -->
                                                    <div class="col-lg-6 mb-4">
                                                        <label class="title">Service Title</label>
                                                        <input type="text" name="title" class="form-control" placeholder="Enter service title..." value="{{ old('title', $service->title) }}" required>
                                                        @error('title')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                
                                                    <!-- Description -->
                                                    <div class="col-lg-12 mb-4">
                                                        <label class="title mb-3">Description</label>
                                                        <textarea name="description" class="form-control" placeholder="Enter service description..." rows="4">{{ old('description', $service->description) }}</textarea>
                                                        @error('description')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                
                                                    <!-- Price -->
                                                    <div class="col-lg-6 mb-4">
                                                        <label class="title">Price</label>
                                                        <input type="number" name="price" class="form-control" placeholder="Enter service price..." value="{{ old('price', $service->price) }}" step="0.01" required>
                                                        @error('price')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                
                                                    <!-- Duration -->
                                                    <div class="col-lg-6 mb-4">
                                                        <label class="title">Duration (Days)</label>
                                                        <input type="number" name="duration" class="form-control" placeholder="Enter duration..." value="{{ old('duration', $service->duration) }}">
                                                        @error('duration')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                
                                                    <!-- Reminder Fields -->
                                                    <div class="container">
                                                        <!-- Reminders Row -->
                                                        <div class="row">
                                                            @foreach (['first', 'second', 'followup'] as $reminderType)
                                                                <div class="col-lg-4 mb-4">
                                                                    <div class="form-check mb-2">
                                                                        <input type="hidden" name="{{ $reminderType }}_reminder_enabled" value="0">
                                                                        <input 
                                                                            type="checkbox" 
                                                                            class="form-check-input" 
                                                                            id="{{ $reminderType }}ReminderToggle" 
                                                                            name="{{ $reminderType }}_reminder_enabled" 
                                                                            value="1"
                                                                            {{ old($reminderType . '_reminder_enabled', $service->{$reminderType . '_reminder_enabled'}) ? 'checked' : '' }}
                                                                            onclick="toggleReminder('{{ $reminderType }}')"
                                                                        >
                                                                        <label class="form-check-label" for="{{ $reminderType }}ReminderToggle">
                                                                            {{ ucfirst($reminderType) }} Reminder
                                                                        </label>
                                                                    </div>
                                                                    <div id="{{ $reminderType }}ReminderFields" style="{{ old($reminderType . '_reminder_enabled', $service->{$reminderType . '_reminder_enabled'}) ? '' : 'display: none;' }}">
                                                                        <label class="title">{{ ucfirst($reminderType) }} Reminder Date/Time</label>
                                                                        <input 
                                                                            type="datetime-local" 
                                                                            id="{{ $reminderType }}ReminderDate" 
                                                                            name="{{ $reminderType }}_reminder_date" 
                                                                            class="form-control mb-3"
                                                                            value="{{ old($reminderType . '_reminder_date', $service->{$reminderType . '_reminder_date'}) }}"
                                                                        >
                                                                        @error($reminderType . '_reminder_date')
                                                                            <div class="text-danger">{{ $message }}</div>
                                                                        @enderror
                                
                                                                        <label class="title">{{ ucfirst($reminderType) }} Reminder Message</label>
                                                                        <textarea 
                                                                            name="{{ $reminderType }}_reminder_message" 
                                                                            class="form-control" 
                                                                            rows="3"
                                                                        >{{ old($reminderType . '_reminder_message', $service->{$reminderType . '_reminder_message'}) }}</textarea>
                                                                        @error($reminderType . '_reminder_message')
                                                                            <div class="text-danger">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                
                                                        <!-- File Upload Row -->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="title">Service Image</label>
                                                                <div class="item-wrapper one">
                                                                    <div class="item">
                                                                        <div class="item-inner">
                                                                            <div class="item-content">
                                                                                <div class="image-upload text-center position-relative" style="width: 100%; height: 300px; border: 1px dashed #ddd; border-radius: 5px; margin-bottom: 20px; background: #f8f8f9; color: #666; overflow: hidden;">
                                                                                    <label for="file_upload" style="cursor: pointer; height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; position: relative;">
                                                                                        @if($service->image)
                                                                                            <img src="{{ asset('storage/' . $service->image) }}" alt="" class="uploaded-image" style="max-height: 400px; border-radius: 5px; width: auto; margin-bottom: 20px;">
                                                                                        @else
                                                                                            <img src="" alt="" class="uploaded-image d-none" style="max-height: 400px; border-radius: 5px; width: auto; margin-bottom: 20px;">
                                                                                        @endif
                                                                                        <div>
                                                                                            <i class="fa fa-cloud-upload" style="font-size: 6em; color: #ccc;"></i>
                                                                                            <h5><b>Choose Your Image to Upload</b></h5>
                                                                                            <h6 class="mt-3">Or Drop Your Image Here</h6>
                                                                                        </div>
                                                                                        <input type="file" name="image" id="file_upload" class="position-absolute w-100 h-100" style="opacity: 0; cursor: pointer;">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('image') 
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                
                                                    <div class="col-lg-12 mt-4">
                                                        <div class="d-flex flex-wrap align-items-center justify-content-center">
                                                            <button type="submit" class="btn btn-outline-primary">Update Service</button>
                                                        </div>
                                                    </div>
                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                
                                <script>
                                   
                                
                                    
                                    function toggleReminder(reminderType) {
                                        const fields = document.getElementById(`${reminderType}ReminderFields`);
                                        if (fields.style.display === "none") {
                                            fields.style.display = "block";
                                        } else {
                                            fields.style.display = "none";
                                        }
                                    }
                                    window.onload = setCurrentDateTime;

                                    window.addEventListener('load', function () {
                                        document.getElementById('loading').style.display = 'none';
                                    });
                                </script>
                        </div>
                    </div>
                </div>
         </div>
    </div>

   
    