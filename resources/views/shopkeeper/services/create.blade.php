@extends('shopkeeper.layouts.app')
@section('title', 'Dashboard')
@section('content')

<main class="d-flex justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <div>
                    <h4>
                        <a href="{{route('services.index')}}">
                            <i class="la la-arrow-left"></i>
                        </a>
                        &nbsp;
                        Add Service
                    </h4>
                </div>
                <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <div class="row">
                        <!-- Service Title -->
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="title">Service Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter service title..." value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" placeholder="Enter service description..." rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="row align-items-end">
                                <!-- Service Provider -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="service_provider_id">Service Provider</label>
                                        <select name="service_provider_id" class="form-control" required>
                                            <option value="">Select Service Provider</option>
                                            @foreach ($serviceProviders as $provider)
                                                <option value="{{ $provider->id }}" {{ old('service_provider_id') == $provider->id ? 'selected' : '' }}>
                                                    {{ $provider->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('service_provider_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        @if(Auth::user()->is_permitted)                                    
                                            <input type="number" name="price" class="form-control" placeholder="Enter price..." 
                                                   value="{{ old('price') }}" step="0.01" required>
                                        @else
                                            <input type="number" name="price" class="form-control" value="0" readonly>
                                        @endif
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                

                                <!-- Duration -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="duration">Duration</label>
                                        <input type="number" name="duration" class="form-control" placeholder="Enter duration..." value="{{ old('duration') }}">
                                        @error('duration')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Duration Type -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="duration_type">Duration Type</label>
                                        <select name="duration_type" class="form-control">
                                            <option value="hours" {{ old('duration_type') == 'hours' ? 'selected' : '' }}>Hours</option>
                                            <option value="days" {{ old('duration_type') == 'days' ? 'selected' : '' }}>Days</option>
                                            <option value="months" {{ old('duration_type') == 'months' ? 'selected' : '' }}>Months</option>
                                        </select>
                                        @error('duration_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   <!-- Reminder Fields (First, Second, Followup) -->
                   @foreach (['first', 'second', 'followup'] as $reminderType)
                        <div class="col-md-12 mb-2 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="hidden" name="{{ $reminderType }}_reminder_enabled" value="0">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="{{ $reminderType }}ReminderToggle"
                                    name="{{ $reminderType }}_reminder_enabled"
                                    value="1"
                                    onclick="toggleReminder('{{ $reminderType }}')"
                                >
                                <label class="custom-control-label" for="{{ $reminderType }}ReminderToggle">
                                    {{ ucfirst($reminderType) }} Reminder
                                </label>
                                <div id="{{ $reminderType }}ReminderFields" class="mt-2" style="display: none; margin-left: -23px">
                                    <div class="d-flex align-items-center mb-3">
                                        @if ($reminderType == 'followup')
                                            <div>Send follow-up reminder after</div>
                                        @else
                                            <div>Send {{ $reminderType }} reminder before</div>
                                        @endif
                                        <div class="mx-1">
                                            <input
                                                type="number"
                                                class="reminder_input"
                                                name="{{ $reminderType }}_reminder_duration"
                                                id="{{ $reminderType }}ReminderDuration"
                                                value="{{ old($reminderType . '_reminder_duration') }}"
                                            />
                                        </div>
                                        <div class="mx-1">
                                            <select
                                                name="{{ $reminderType }}_reminder_duration_type"
                                                id="{{ $reminderType }}ReminderDurationType"
                                                class="form-control"
                                                style="height: 32px"
                                                onchange="validateReminderDuration('{{ $reminderType }}')"
                                            >
                                                <option value="hours" {{ old($reminderType . '_reminder_duration_type') == 'hours' ? 'selected' : '' }}>Hours</option>
                                                <option value="days" {{ old($reminderType . '_reminder_duration_type') == 'days' ? 'selected' : '' }}>Days</option>
                                            </select>
                                        </div>
                                    </div>
                                    @error($reminderType . '_reminder_duration')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <!-- Reminder Message -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="title mb-0">{{ ucfirst($reminderType) }} Reminder Message</label>
                                        <button
                                            type="button"
                                            class="copy-button"
                                            style="border: none; background-color: white;"
                                            data-key="{{ ucfirst($reminderType) }} Reminder"
                                            onclick="copyReminderMessage('{{ $reminderType }}')"
                                        >
                                            <i class="las la-paste" style="font-size: 22px;"></i>
                                        </button>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <textarea
                                            name="{{ $reminderType }}_reminder_message"
                                            id="{{ $reminderType }}ReminderMessage"
                                            class="form-control reminder-message"
                                            rows="3"
                                        >{{ old($reminderType . '_reminder_message') }}</textarea>
                                    </div>
                                    @error($reminderType . '_reminder_message')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach



                        {{--notify selection --}}

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Send Reminders via:</label>
                                <div class=" align-items-center">
                                    <div>
                                        <input 
                                            type="checkbox" 
                                            name="notify_via_email" 
                                            id="notify_via_email" 
                                            value="1" 
                                            {{ old('notify_via_email', $service->notify_via_email ?? 0) ? 'checked' : '' }}
                                        >
                                        <label for="notify_via_email" class="ms-1">Email</label>
                                    </div>
                                    <div>
                                        <input 
                                            type="checkbox" 
                                            name="notify_via_sms" 
                                            id="notify_via_sms" 
                                            value="1" 
                                            {{ old('notify_via_sms', $service->notify_via_sms ?? 0) ? 'checked' : '' }}
                                        >
                                        <label for="notify_via_sms" class="ms-1">SMS</label>
                                    </div>
                                </div>
                            </div>
                        </div>


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
                                                        <img src="" alt="" class="uploaded-image d-none" style="max-height: 400px; border-radius: 5px; width: auto; margin-bottom: 20px;">
                                                        <div>
                                                            <i class="fa fa-cloud-upload" style="font-size: 6em; color: #ccc;"></i>
                                                            <h5><b>Choose Your Image to Upload</b></h5>
                                                            <h6 class="mt-3">Or Drop Your Image Here</h6>
                                                            <p class="mt-2" id="filename"></p>
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
                                Add Service &nbsp;
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
        function toggleReminder(reminderType) {
        var reminderToggle = document.getElementById(reminderType + 'ReminderToggle');
        var reminderFields = document.getElementById(reminderType + 'ReminderFields');

        // If reminder is checked, show the fields, else hide them
        if (reminderToggle.checked) {
            reminderFields.style.display = "block";
        } else {
            reminderFields.style.display = "none";
        }

        // Trigger validation when reminder is enabled
        if (reminderToggle.checked) {
            validateReminderDuration(reminderType);
        }
    }

// Validate the duration of the reminder and ensure the second reminder follows the rules
            function validateReminderDuration(reminderType) {
                var firstDuration = parseFloat(document.getElementById('firstReminderDuration').value);
                console.log(firstDuration);
                var firstDurationType = document.getElementById('firstReminderDurationType').value;
                console.log(firstDurationType);

                var secondDuration = parseFloat(document.getElementById('secondReminderDuration').value);
                console.log(secondDuration);

                var secondDurationType = document.getElementById('secondReminderDurationType').value;
                console.log(firstDurationType);


                // Handle second reminder duration validation only if both first and second reminders are enabled
                if (reminderType === 'second') {
            if (firstDurationType === 'hours' && secondDurationType === 'days') {
                alert("Second reminder cannot be in days when the first reminder is in hours.");
                document.getElementById('secondReminderDurationType').value = 'hours'; // Revert to hours
            } else if (firstDurationType === 'hours' && secondDuration > firstDuration) {
                alert("Second reminder cannot be more than 2 hours after the first reminder.");
                document.getElementById('secondReminderDuration').value = firstDuration ; // Set second reminder duration first
            } else if (firstDurationType === 'days' && secondDurationType === 'days' && secondDuration >= firstDuration) {
                alert("Second reminder must be less than the first reminder's days.");
                document.getElementById('secondReminderDuration').value = (firstDuration - 1); // Adjust second reminder to less than first
            }
        }

            }

    // Initialize the toggle behavior on page load
    window.onload = function() {
        @foreach (['first', 'second', 'followup'] as $reminderType)
            toggleReminder('{{ $reminderType }}');
        @endforeach
    };


    // Update the file name when a file is selected
    function uploaded(tmp_path)
    {
        const fileInput = document.getElementById('file_upload');
        const file = fileInput.files[0];
        if (file) {
            document.getElementById("filename").innerText = file.name;
        }
        else{
            document.getElementById("filename").innerText = '';
        }
    }




    document.addEventListener('DOMContentLoaded', function () {
        // Attach click event to all copy buttons
        document.querySelectorAll('.copy-button').forEach(button => {
            button.addEventListener('click', function () {
                // Get the key to identify the message
                const key = this.getAttribute('data-key');

                // Make an AJAX request to fetch the message based on the key
                fetch(`/get-template-message?key=${encodeURIComponent(key)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Find the associated textarea and set its value
                            const reminderType = key.toLowerCase().replace(' reminder', '');
                            const textarea = document.getElementById(`${reminderType}ReminderMessage`);
                            textarea.value = data.message;
                        } else {
                            alert('Message not found!');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching the template:', error);
                        alert('An error occurred while fetching the message.');
                    });
            });
        });
    });

    function copyReminderMessage(reminderType) {
        // Get the reminder message textarea for the specific reminder
        var reminderTextArea = document.querySelector(`[name='${reminderType}_reminder_message']`);
        
        // Select and copy the text
        reminderTextArea.select();
        document.execCommand('copy');

    }



</script>
@endsection
