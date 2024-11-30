<section>
    <form method="post" action="{{ route('profile.schedule.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="row">
            <!-- First Column for the first 4 days -->
            <div class="col-md-6">
                @foreach (['monday', 'tuesday', 'wednesday', 'thursday'] as $day)
                    <div class="form-group mb-3">
                        <div class="d-flex align-items-center">
                            <!-- Day Checkbox -->
                            <input type="checkbox" 
                                   name="{{ $day }}_enabled" 
                                   id="{{ $day }}Enabled" 
                                   class="custom-control-input" 
                                   value="1" 
                                   {{ old($day.'_enabled', $shopSchedule->{$day.'_enabled'}) ? 'checked' : '' }}>
                            <label for="{{ $day }}Enabled" class="custom-control-label ml-2">
                                {{ ucfirst($day) }}
                            </label>
                            
                            <!-- Start Time & End Time -->
                            <div class="ml-auto d-flex align-items-center">
                                <div class="mr-2">From:</div>
                                <input type="time" 
                                       name="{{ $day }}_start_time" 
                                       id="{{ $day }}StartTime" 
                                       class="form-control form-control-sm" 
                                       style="width: 80px;" 
                                       value="{{ old($day.'_start_time', $shopSchedule->{$day.'_start_time'}) }}">
                                <div class="mr-2 ml-2">To:</div>
                                <input type="time" 
                                       name="{{ $day }}_end_time" 
                                       id="{{ $day }}EndTime" 
                                       class="form-control form-control-sm" 
                                       style="width: 80px;" 
                                       value="{{ old($day.'_end_time', $shopSchedule->{$day.'_end_time'}) }}">
                            </div>
                        </div>

                        @error($day.'_enabled')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error($day.'_start_time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error($day.'_end_time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <!-- Second Column for the remaining 3 days -->
            <div class="col-md-6">
                @foreach (['friday', 'saturday', 'sunday'] as $day)
                    <div class="form-group mb-3">
                        <div class="d-flex align-items-center">
                            <!-- Day Checkbox -->
                            <input type="checkbox" 
                                   name="{{ $day }}_enabled" 
                                   id="{{ $day }}Enabled" 
                                   class="custom-control-input" 
                                   value="1" 
                                   {{ old($day.'_enabled', $shopSchedule->{$day.'_enabled'}) ? 'checked' : '' }}>
                            <label for="{{ $day }}Enabled" class="custom-control-label ml-2">
                                {{ ucfirst($day) }}
                            </label>
                            
                            <!-- Start Time & End Time -->
                            <div class="ml-auto d-flex align-items-center">
                                <div class="mr-2">From:</div>
                                <input type="time" 
                                       name="{{ $day }}_start_time" 
                                       id="{{ $day }}StartTime" 
                                       class="form-control form-control-sm" 
                                       style="width: 80px;" 
                                       value="{{ old($day.'_start_time', $shopSchedule->{$day.'_start_time'}) }}">
                                <div class="mr-2 ml-2">To:</div>
                                <input type="time" 
                                       name="{{ $day }}_end_time" 
                                       id="{{ $day }}EndTime" 
                                       class="form-control form-control-sm" 
                                       style="width: 80px;" 
                                       value="{{ old($day.'_end_time', $shopSchedule->{$day.'_end_time'}) }}">
                            </div>
                        </div>

                        @error($day.'_enabled')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error($day.'_start_time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error($day.'_end_time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>

            <!-- Save Button -->
            <div class="col-md-12 mb-3 text-right">
                <button class="btn btn-dark py-1 px-3">
                    {{ __('Save Schedule') }}
                </button>
            </div>
        </div>
    </form>
</section>