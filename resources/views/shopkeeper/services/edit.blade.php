@extends('shopkeeper.layouts.app')
@section('title', 'Edit Service')
@section('content')

<main class="d-flex justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <div>
                    <h4>
                        <a href="{{ route('services.index') }}">
                            <i class="la la-arrow-left"></i>
                        </a>
                        &nbsp;
                        Edit Service
                    </h4>
                </div>
                <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    @method('PUT') <!-- HTTP method spoofing for PUT request -->
                    
                    <div class="row">
                        <!-- Service Provider -->
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="service_provider_id">Service Provider</label>
                                <select name="service_provider_id" class="form-control" required>
                                    <option value="">Select Service Provider</option>
                                    @foreach ($serviceProviders as $provider)
                                        <option value="{{ $provider->id }}" {{ $service->service_provider_id == $provider->id ? 'selected' : '' }}>
                                            {{ $provider->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_provider_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Service Title -->
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="title">Service Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter service title..." value="{{ old('title', $service->title) }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" placeholder="Enter service description..." rows="4">{{ old('description', $service->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="Enter service price..." value="{{ old('price', $service->price) }}" step="0.01" id="price" required>
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Duration (Time) -->
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="duration">Duration (Time)</label>
                                <!-- Make sure to set a default value if the service has a duration set -->
                                <input type="time" name="duration" class="form-control" value="{{ old('duration', $service->duration ?? '00:00') }}" id="duration">
                                @error('duration')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        

                        <!-- Reminder Fields (First, Second, Followup) -->
                        @foreach (['first', 'second', 'followup'] as $reminderType)
                            <div class="col-md-12 mb-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="hidden" name="{{ $reminderType }}_reminder_enabled" value="0">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="{{ $reminderType }}ReminderToggle"
                                        name="{{ $reminderType }}_reminder_enabled"
                                        value="1"
                                        {{ $service->{$reminderType . '_reminder_enabled'} ? 'checked' : '' }}
                                        onclick="toggleReminder('{{ $reminderType }}')"
                                    >
                                    <label class="custom-control-label" for="{{ $reminderType }}ReminderToggle">
                                        {{ ucfirst($reminderType) }} Reminder
                                    </label>
                                    <div id="{{ $reminderType }}ReminderFields" class="mt-2" style="display: {{ $service->{$reminderType . '_reminder_enabled'} ? 'block' : 'none' }}; margin-left: -23px">
                                        <div class="d-flex align-items-center mb-3">
                                            @if ($reminderType == 'followup')
                                                <!-- For Follow-up reminder, show 'after' -->
                                                <div>
                                                    Send follow-up reminder after
                                                </div>
                                            @else
                                                <!-- For first and second reminder, show 'before' -->
                                                <div>
                                                    Send {{ $reminderType }} reminder before
                                                </div>
                                            @endif
                                            <div class="mx-1">
                                                <input type="number" class="reminder_input" name="{{ $reminderType }}_reminder_hours" id="{{ $reminderType }}ReminderHours" value="{{ old($reminderType . '_reminder_hours', $service->{$reminderType . '_reminder_hours'}) }}" />
                                            </div>
                                            <div>hour(s)</div>
                                        </div>
                                        @error($reminderType . '_reminder_hours')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                        <label class="title">{{ ucfirst($reminderType) }} reminder message</label>
                                        <textarea name="{{ $reminderType }}_reminder_message" class="form-control" rows="3">{{ old($reminderType . '_reminder_message', $service->{$reminderType . '_reminder_message'}) }}</textarea>
                                        @error($reminderType . '_reminder_message')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Service Image -->
                        <div class="col-md-12 mb-2 mt-2">
                            <div class="form-group">
                                <label class="title">Service Image</label>
                                <div class="item-wrapper one">
                                    <div class="item">
                                        <div class="item-inner">
                                            <div class="item-content">
                                                <div class="image-upload text-center position-relative" style="width: 100%; height: 300px; border: 1px dashed #ddd; border-radius: 5px; margin-bottom: 20px; background: #f8f8f9; color: #666; overflow: hidden;">
                                                    <label for="file_upload" style="cursor: pointer; height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; position: relative;">
                                                        @if ($service->image)
                                                            <img src="{{ asset('storage/' . $service->image) }}" alt="Uploaded Image" class="uploaded-image" style="max-height: 400px; border-radius: 5px; width: auto; margin-bottom: 20px;">
                                                        @else
                                                            <img src="" alt="" class="uploaded-image d-none" style="max-height: 400px; border-radius: 5px; width: auto; margin-bottom: 20px;">
                                                        @endif
                                                        <div>
                                                            <i class="fa fa-cloud-upload" style="font-size: 6em; color: #ccc;"></i>
                                                            <h5><b>Choose Your Image to Upload</b></h5>
                                                            <h6 class="mt-3">Or Drop Your Image Here</h6>
                                                            <p class="mt-2" id="filename">{{ $service->image ? basename($service->image) : '' }}</p>
                                                        </div>
                                                        <input type="file" name="image" id="file_upload" class="position-absolute w-100 h-100" style="opacity: 0; cursor: pointer;" onchange="uploaded(this.value)">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 mb-2">
                            <button class="btn btn-dark w-100 py-2 d-flex align-items-center justify-content-center">
                                Update Service &nbsp;
                                <i class="la la-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
<script>
    // Toggle visibility of reminder fields
    function toggleReminder(type){
        const fields = document.getElementById(type + 'ReminderFields');
        fields.style.display = fields.style.display === 'none' ? 'block' : 'none';
    }

    // Update the file name when a file is selected
    function uploaded(filename){
        document.getElementById('filename').textContent = filename.split('\\').pop();
    }
</script>
@endsection
