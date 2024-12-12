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
                        Edit Service
                    </h4>
                </div>
                <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    @method('PUT')
                    <div class="row">
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
                        
                        <div class="col-md-12 mb-3">
                            <div class="row align-items-end">
                                <!-- Service Provider -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="service_provider_id">Service Provider</label>
                                        <select name="service_provider_id" class="form-control" required>
                                            <option value="">Select Service Provider</option>
                                            @foreach ($serviceProviders as $provider)
                                                <option value="{{ $provider->id }}" {{ old('service_provider_id', $service->service_provider_id) == $provider->id ? 'selected' : '' }}>
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
                                        <input type="number" name="duration" class="form-control" placeholder="Enter duration..." value="{{ old('duration', $service->duration) }}">
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
                                            <option value="hours" {{ old('duration_type', $service->duration_type) == 'hours' ? 'selected' : '' }}>Hours</option>
                                            <option value="days" {{ old('duration_type', $service->duration_type) == 'days' ? 'selected' : '' }}>Days</option>
                                            <option value="months" {{ old('duration_type', $service->duration_type) == 'months' ? 'selected' : '' }}>Months</option>
                                        </select>
                                        @error('duration_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input 
                                        type="checkbox" 
                                        name="notify_via_email" 
                                        id="notify_via_email" 
                                        value="1" 
                                        {{ old('notify_via_email', $service->notify_via_email) ? 'checked' : '' }}
                                    >
                                    <label for="notify_via_email">Notify via Email</label>
                                    
                                </div>
                                
                                <div class="form-group">
                                    <input 
                                        type="checkbox" 
                                        name="notify_via_sms" 
                                        id="notify_via_sms" 
                                        value="1" 
                                        {{ old('notify_via_sms', $service->notify_via_sms) ? 'checked' : '' }}
                                    >
                                    <label for="notify_via_sms">Notify via SMS</label>
                                    
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
                                            <!-- For Follow-up reminder, show 'after' -->
                                            <div>Send follow-up reminder after</div>
                                        @else
                                            <!-- For first and second reminder, show 'before' -->
                                            <div>Send {{ $reminderType }} reminder before</div>
                                        @endif
                                        <div class="mx-1">
                                            <input type="number" class="reminder_input" name="{{ $reminderType }}_reminder_hours" id="{{ $reminderType }}ReminderHours" />
                                        </div>
                                        <div>hour(s)</div>
                                    </div>
                                    @error($reminderType . '_reminder_hours')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror                                
                                    
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="title mb-0">{{ ucfirst($reminderType) }} Reminder Message</label>
                                        <!-- Copy icon on the right -->
                                        <button 
                                            type="button" 
                                            class="copy-button"
                                            style="border: none; background-color: white;"
                                            data-key="{{ ucfirst($reminderType) }} Reminder"
                                            onclick="copyReminderMessage('{{ $reminderType }}')"
                                        >
                                        
                                            <i class="las la-paste" style="font-size: 22px;"></i> <!-- Using 'la-paste' icon -->
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
                                                            <img src="{{ asset('storage/' . $service->image) }}" alt="" class="uploaded-image" style="max-height: 400px; border-radius: 5px; width: auto; margin-bottom: 20px;">
                                                        @endif
                                                        <input type="file" name="image" id="file_upload" class="position-absolute w-100 h-100" style="opacity: 0; cursor: pointer;">
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
                                <i class="la la-save"></i>
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
    function toggleReminder(type){
        const fields = document.getElementById(type + 'ReminderFields');
        fields.style.display = fields.style.display === 'none' ? 'block' : 'none';
    }

    function uploaded(filename){
        document.getElementById('filename').textContent = filename.split('\\').pop();
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
