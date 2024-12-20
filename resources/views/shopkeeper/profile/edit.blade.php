    @extends('shopkeeper.layouts.app')
    @section('title', 'Dashboard')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    @section('content')
    <style>
        #iframeLink::selection {
        background-color: transparent; 
    }

  
    .templates-section ul {
        padding: 0;
        list-style: none;
    }

    .templates-section li {
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        background: #f9f9f9;
    }
    .icon-button {
    border: none;
    background: none;
    padding: 0;
    cursor: pointer;
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
                 <!-- Password Update Section -->
                 <h4 class="mb-4 mt-5">Change Password</h4>
                 @include('shopkeeper.profile.partials.update-password-form')
 

                <h4 class="mb-4">Update Shop Schedule</h4>
                @include('shopkeeper.profile.partials.shop-schedule')

                <h4 class="mb-4 mt-4">Holidays</h4>
                <div class="mb-3">
                    @if($user->holidays->isEmpty())
                        <p class="text-muted">No holidays found. Add holidays to mark days or hours as unavailable.</p>
                    @else
                    <ul class="list-group">
                        @foreach($user->holidays as $holiday)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $holiday->date->format('F d, Y') }}</strong>
                    
                                    @if($holiday->is_full_day)
                                        <span class="badge bg-danger text-white ms-2">Full Day</span>
                                    @else
                                    <span class="badge bg-warning text-dark ms-2">
                                        {{ $holiday->start_time ? $holiday->start_time->format('H:i') : 'Start time not set' }} - 
                                        {{ $holiday->end_time ? $holiday->end_time->format('H:i') : 'End time not set' }}
                                    </span>

                                        {{-- <span class="badge bg-warning text-dark ms-2">{{ $holiday->start_time->format('H:i') }} - {{ $holiday->end_time->format('H:i') }}</span> --}}
                                    @endif
                                    @if($holiday->description)
                                        <p class="mb-0 mt-1 text-muted">Reason: {{ $holiday->description }}</p>
                                    @endif
                                </div>
                                <div>
                                    <!-- Edit Holiday Button -->
                                    <button class="icon-button text-primary" style="font-size: 1.5rem;" onclick="openEditHolidayModal({{ $holiday->id }})">
                                        <i class="las la-edit"></i>
                                    </button>
                    
                                    <!-- Delete Holiday Form -->
                                    <form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="icon-button text-danger" type="submit" style="font-size: 1.5rem;">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    
                    @endif
                </div>
                
                <div class="col-md-12 mb-3 text-right">
                    <button class="btn btn-dark py-1 px-3" data-bs-toggle="modal" data-bs-target="#addHolidayModal">
                        Add Holiday
                    </button>
                </div>


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


                         
               
    
                {{---------------Templates---------------------}}

                <h4 class="mb-4 mt-5">Template Messages</h4>
                <div class="templates-section mb-3">
                    @if($templates->isEmpty())
                        <p class="text-muted">No templates found. Create one to customize your reminder messages.</p>
                    @else
                        <ul class="list-group">
                            @foreach($templates as $template)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ ucfirst(str_replace('_', ' ', $template->key)) }}:</strong>
                                        <p class="mb-0 text-muted">{{ $template->value }}</p>
                                    </div>
                                    <div>
                                        <button class="icon-button" onclick="openEditModal({{ $template }})" style="font-size: 1.5rem;">
                                            <i class="la la-edit"></i>
                                        </button>
                                        <form action="{{ route('templates.destroy', $template->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="icon-button text-danger" type="submit" style="font-size: 1.5rem;">
                                                <i class="las la-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="col-md-12 mb-3 text-right">
                    <button class="btn btn-dark py-1 px-3" onclick="openAddModal()">Add Template</button>
                </div>
                
                <!-- Add/Edit Template Modal -->
                <div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 15px;">
                            <form id="templateForm" method="POST" action="">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="templateModalLabel">Add Template</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border:none; background-color:white;">
                                        <i class="las la-times-circle" style="font-size: 22px;"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="templateKey" class="form-label">Key</label>
                                        <input type="text" class="form-control" id="templateKey" name="key" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="templateValue" class="form-label">Value</label>
                                        <textarea class="form-control" id="templateValue" name="value" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Template</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{----HOLIDAY MODAL----}}


                <!-- Add Holiday Modal -->
                <div class="modal fade" id="addHolidayModal" tabindex="-1" aria-labelledby="addHolidayModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 15px;">
                            <form id="addHolidayForm" method="POST" action="{{ route('holidays.store') }}">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addHolidayModalLabel">Add Holiday</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border:none; background-color:white;">
                                        <i class="las la-times-circle" style="font-size: 22px;"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    <div class="mb-3">
                                        <label for="holidayDate" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="holidayDate" name="date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="holidayStartTime" class="form-label">Start Time</label>
                                        <input type="time" class="form-control" id="holidayStartTime" name="start_time">
                                    </div>
                                    <div class="mb-3">
                                        <label for="holidayEndTime" class="form-label">End Time</label>
                                        <input type="time" class="form-control" id="holidayEndTime" name="end_time">
                                    </div>
                                    <div class="mb-3">
                                        <label for="holidayDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="holidayDescription" name="description" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="addIsFullDay" name="is_full_day" value="1">
                                        <label class="form-check-label" for="addIsFullDay">Full Day</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Holiday</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                

                        <!-- Edit Holiday Modal -->
                <div class="modal fade" id="editHolidayModal" tabindex="-1" aria-labelledby="editHolidayModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 15px;">
                            <form id="editHolidayForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editHolidayModalLabel">Edit Holiday</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border:none; background-color:white;">
                                        <i class="las la-times-circle" style="font-size: 22px;"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="editUserId" name="user_id" value="{{ auth()->id() }}">
                                    <div class="mb-3">
                                        <label for="editHolidayDate" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="editHolidayDate"  name="date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editHolidayStartTime" class="form-label">Start Time</label>
                                        <input type="time" class="form-control" id="editHolidayStartTime" name="start_time">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editHolidayEndTime" class="form-label">End Time</label>
                                        <input type="time" class="form-control" id="editHolidayEndTime" name="end_time">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editHolidayDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="editHolidayDescription" name="description" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="editIsFullDay" name="is_full_day" value="1">
                                        <label class="form-check-label" for="editIsFullDay">Full Day</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Holiday</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                



    </main>

    @endsection
    @section('scripts')


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        //holidays
        document.addEventListener("DOMContentLoaded", () => {
        // Reset forms on modal close
        const modals = ["addHolidayModal", "editHolidayModal"];
        modals.forEach((modalId) => {
            const modalElement = document.getElementById(modalId);
            modalElement.addEventListener("hidden.bs.modal", () => {
                const form = modalElement.querySelector("form");
                if (form) {
                    form.reset();
                    form.action = ""; // Reset form action for edit modal
                }
            });
        });

       


    // Open Edit Modal and populate data
    window.openEditHolidayModal = function (holidayId) {
        let holidays = @json($user->holidays); // Pass holidays data to JS
        let holiday = holidays.find(h => h.id === holidayId);
        // console.log('Holiday:', holiday);
        console.log(holiday.date)

        if (holiday) {
            const formattedDate = holiday.date.split('T')[0];
            console.log(formattedDate)
            // Populate the form fields in the modal
            document.getElementById('editHolidayDate').value = formattedDate;
            document.getElementById('editHolidayStartTime').value = holiday.start_time ;
            document.getElementById('editHolidayEndTime').value = holiday.end_time ;
            document.getElementById('editHolidayDescription').value = holiday.description ;
            document.getElementById('editIsFullDay').checked = holiday.is_full_day;
            document.getElementById('editHolidayForm').action = `/holidays/${holiday.id}`;

            $('#editHolidayModal').modal('show');
        } else {
        console.error('Holiday not found');
    }
    }
});




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

        //template edit modal 
        let isEdit = false;
    let editTemplateId = null;

    function openAddModal() {
        isEdit = false;
        editTemplateId = null;
        document.getElementById('templateForm').action = "{{ route('templates.store') }}";
        document.getElementById('templateModalLabel').innerText = "Add Template";
        document.getElementById('templateKey').value = "";
        document.getElementById('templateValue').value = "";
        new bootstrap.Modal(document.getElementById('templateModal')).show();
    }

    function openEditModal(template) 
    {
        isEdit = true;
        editTemplateId = template.id;
        document.getElementById('templateForm').action = `/templates/${template.id}`;
        document.getElementById('templateModalLabel').innerText = "Edit Template";
        document.getElementById('templateKey').value = template.key;
        document.getElementById('templateValue').value = template.value;
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        document.getElementById('templateForm').appendChild(methodInput);
        new bootstrap.Modal(document.getElementById('templateModal')).show();
    }
    </script>
    @endsection
