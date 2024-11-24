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
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="" class="">Service Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter service title..." value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="" class="">Description</label>
                                <textarea name="description" class="form-control" placeholder="Enter service description..." rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="Enter service price..." value="{{ old('price') }}" step="0.01" id="price" required>
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-group">
                                <label for="duration">Duration</label>
                                <input type="number" name="duration" class="form-control" placeholder="Enter duration in days..." value="{{ old('duration') }}" id="duration">
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
                                >
                                <label class="custom-control-label" for="{{ $reminderType }}ReminderToggle">
                                    {{ ucfirst($reminderType) }} Reminder
                                </label>
                                <div id="{{ $reminderType }}ReminderFields" class="mt-2" style="display: none;margin-left: -23px">
                                    <div class="d-flex align-items-center mb-3">
                                        <div>
                                            Send {{$reminderType}} reminder after
                                        </div>
                                        <div class="mx-1">
                                            <input type="number" class="reminder_input" value="2" name="{{ $reminderType }}_reminder_days"
                                            id="{{ $reminderType }}ReminderDays" />
                                        </div>
                                        <div>day(s) at</div>
                                        <div class="mx-1">
                                            <input type="time"
                                                class="reminder_input time"
                                                value="08:00"
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
                                    >{{ old($reminderType . '_reminder_message') }}</textarea>
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
    function toggleReminder(type){
        const fields = document.getElementById(type + 'ReminderFields');
        fields.style.display = fields.style.display === 'none' ? 'block' : 'none';
    }

    function setCurrentDateTime() {
        const now = new Date();
        const formattedDateTime = now.toISOString().slice(0, 16);
        ['first', 'second', 'followup'].forEach(reminderType => {
            const dateInput = document.getElementById(`${reminderType}ReminderDate`);
            if (dateInput) {
                dateInput.value = formattedDateTime;
            }
        });
    }


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

    function uploaded(tmp_path)
    {
        const fileInput = document.getElementById('file_upload');
        const file = fileInput.files[0];
        if (file) {
            $("#filename").html(file.name)
        }
        else{
            $("#filename").html('')
        }
    }
</script>
@endsection
