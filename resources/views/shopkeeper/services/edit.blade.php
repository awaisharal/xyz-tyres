@extends('shopkeeper.layouts.app')
@section('title', 'Edit Service')
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
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="" class="">Service Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter service title..." value="{{ old('title', $service->title) }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="" class="">Description</label>
                                <textarea name="description" class="form-control" placeholder="Enter service description..." rows="4">{{ old('description', $service->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="Enter service price..." value="{{ old('price', $service->price) }}" step="0.01" id="price" required>
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="duration">Duration</label>
                                <input type="number" name="duration" class="form-control" placeholder="Enter duration in days..." value="{{ old('duration', $service->duration) }}" id="duration">
                                @error('duration')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                                    onclick="toggleReminder('{{ $reminderType }}')"
                                    {{ old($reminderType.'_reminder_enabled', $service[$reminderType.'_reminder_enabled']) ? 'checked' : '' }}
                                >
                                <label class="custom-control-label" for="{{ $reminderType }}ReminderToggle">
                                    {{ ucfirst($reminderType) }} Reminder
                                </label>
                                <div id="{{ $reminderType }}ReminderFields" class="mt-2" style="display: {{ old($reminderType.'_reminder_enabled', $service[$reminderType.'_reminder_enabled']) ? 'block' : 'none' }}; margin-left: -23px;">
                                    <div class="d-flex align-items-center mb-3">
                                        <div>
                                            Send {{$reminderType}} reminder after
                                        </div>
                                        <div class="mx-1">
                                            <input type="number" class="reminder_input" value="{{ old($reminderType.'_reminder_days', $service[$reminderType.'_reminder_days']) }}" name="{{ $reminderType }}_reminder_days"
                                            id="{{ $reminderType }}ReminderDays" />
                                        </div>
                                        <div>day(s) at</div>
                                        <div class="mx-1">
                                            <input type="time"
                                                class="reminder_input time"
                                                value="{{ old($reminderType.'_reminder_date', $service[$reminderType.'_reminder_date']) }}"
                                                name="{{ $reminderType }}_reminder_date"
                                                id="{{ $reminderType }}ReminderDate" />
                                        </div>
                                    </div>
                                    @error($reminderType . '_reminder_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <label class="title">{{ ucfirst($reminderType) }} reminder message</label>
                                    <textarea
                                        name="{{ $reminderType }}_reminder_message"
                                        class="form-control"
                                        rows="3"
                                    >{{ old($reminderType.'_reminder_message', $service[$reminderType.'_reminder_message']) }}</textarea>
                                    @error($reminderType . '_reminder_message')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-md-12 mb-2 mt-2">
                            <div class="form-group">
                                <label class="title">Service Image</label>
                                <div class="item-wrapper one">
                                    <div class="item">
                                        <div class="item-inner">
                                            <div class="item-content">
                                                <div class="image-upload text-center position-relative" style="width: 100%; height: 300px; border: 1px dashed #ddd; border-radius: 5px; margin-bottom: 20px; background: #f8f8f9; color: #666; overflow: hidden;">
                                                    <label for="file_upload" style="cursor: pointer; height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; position: relative;">
                                                        <img src="{{ asset($service->image ?? 'default-image.png') }}" alt="Service Image" class="uploaded-image" style="max-height: 400px; border-radius: 5px; width: auto; margin-bottom: 20px;">
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
    function toggleReminder(type){
        const fields = document.getElementById(type + 'ReminderFields');
        fields.style.display = fields.style.display === 'none' ? 'block' : 'none';
    }

    function uploaded(tmp_path) {
        const fileInput = document.getElementById('file_upload');
        const file = fileInput.files[0];
        if (file) {
            $("#filename").html(file.name)
        } else {
            $("#filename").html('')
        }
    }
</script>
@endsection
