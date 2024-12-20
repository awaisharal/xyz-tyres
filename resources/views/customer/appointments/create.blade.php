<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --calendly-blue: #006BFF;
            --calendly-purple: #6B21FF;
        }

        body {
            background-color: #f8f9fa;
        }

        .booking-container {
            max-width: 1200px;
            margin: 2rem auto;
            margin-top: 80px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .event-details {
            padding: 2rem;
            border-right: 1px solid #e9ecef;
        }

        .event-icon {
            width: 48px;
            height: 48px;
            background: #ff6b00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 1rem;
        }

        .calendar-header {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
            padding: 1rem;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
        }

        .calendar-day:hover {
            background-color: #f8f9fa;
        }

        .calendar-day.active {
            background-color: var(--calendly-purple);
            color: white;
        }

        .calendar-day.disabled {
            color: #ccc;
            cursor: not-allowed;
        }

        .time-slots {
            padding: 1rem;
        }

        .time-slot {
            display: block;
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            text-align: center;
            color: var(--calendly-purple);
            text-decoration: none;
            transition: all 0.2s;
        }
        .selectted-date{
            font-size: 14px;
        }
        .time-slot:hover {
            background-color: #f8f9fa;
            border-color: var(--calendly-purple);
        }

        .timezone-selector {
            padding: 0.5rem 1rem;
            border-top: 1px solid #e9ecef;
        }

        .powered-by {
            position: absolute;
            top: 1rem;
            right: 1rem;
            transform: rotate(45deg);
            background: #4a4a4a;
            color: white;
            padding: 0.25rem 2rem;
        }

        .time-slot.selected {
            background-color: var(--calendly-purple);
            color: white;
            border: none; /* Optional for cleaner look */
        }
    </style>
</head>
<body >
    
    <div class="booking-container">
        <form id="appointmentForm" action="{{ route('customer.appointment.store', ['service' => $service->id]) }}" method="GET">
            @csrf
            <input type="hidden" name="date" id="selectedDateInput">
            <input type="hidden" name="time" id="selectedTimeInput">
            <input type="hidden" name="service" value="{{ $service->id }}">
        
       
        <div class="row g-0">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Left Sidebar -->
            <div class="col-md-4 event-details">                
                <div class="event-icon">
                    <i class="fs-4">E</i>
                </div>
                <h6 class="text-muted mb-2">{{$user->company}}</h6>
                <h4 class="mb-4">{{$service->title}}</h4>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-clock me-2"></i>
                        <span class="fw-bold">${{$service->price}}</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="far fa-clock me-2"></i>
                        <span>{{$service->duration}} {{$service->duration_type}}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-camera-video me-2"></i>
                    <span class="text-muted">
                      {{$service->description}}
                    </span>
                </div> 
            </div>

            <!-- Main Calendar Area -->
            <div class="col-md-8 position-relative">
                <div class=" d-flex justify-content-between">
                    <!-- Calendar Column -->
                    <div class="col-md6" style="min-width: 65%;width: 100%">
                        <div class="calendar-header">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Select a Date</h5>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-lin" id="prevMonth">
                                        <i class="fa fa-chevron-left"></i>
                                    </button>
                                    <span class="mx-2" id="currentMonth"></span>
                                    <button class="btn btn-lin" id="nextMonth">
                                        <i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="calendar-grid" id="calendarGrid">
                                <!-- Calendar days will be dynamically inserted here -->
                            </div>
                        </div>
                    </div>

                    <!-- Time Slots Column -->
                    <div class="col-md6 d-none" id="timebox" style="width: 100%">
                        <div class="time-slots">
                            <h5 class="mb-4 selectted-date" id="selectedDate"></h5>
                            <div id="timeSlotContainer">
                                <!-- Time slots will be dynamically inserted here -->
                            </div>
                            <button style="background-color: var(--calendly-purple); color: white;" type="submit" id="submitBtn" class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/js/all.min.js" integrity="sha512-1JkMy1LR9bTo3psH+H4SV5bO2dFylgOy+UJhMus1zF4VEFuZVu5lsi4I6iIndE4N9p01z1554ZDcvMSjMaqCBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   

    <script>
        $(document).ready(function() {
            const holidays = @json($holidays);
            const monthNames = ["January", "February", "March", "April", "May", "June", 
                "July", "August", "September", "October", "November", "December"];
            const dayNames = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
            const dayAbbreviations = {
                sunday: "Sun",
                monday: "Mon",
                tuesday: "Tue",
                wednesday: "Wed", 
                thursday: "Thu",
                friday: "Fri",
                saturday: "Sat",
            };
        
            let selectedDate = null;
            let selectedTime = null;
            let scheduleData = {}; // Store the fetched schedule data
        
            function fetchSchedule(userId) {
                return $.ajax({
                    url: `/customer/shop/schedule/${userId}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        scheduleData = data;  // Store the schedule data globally
                    },
                    error: function(error) {
                        console.error("Error fetching schedule:", error);
                    }
                });
            }
        
            function generateCalendar(year, month) {
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                let html = '';
        
                dayNames.forEach(day => {
                    html += `<div class="text-center text-muted">${dayAbbreviations[day]}</div>`;
                });
        
                for (let i = 0; i < firstDay.getDay(); i++) {
                    html += '<div></div>';
                }
        
                for (let day = 1; day <= lastDay.getDate(); day++) {
                    const date = new Date(year, month, day);
                    const dateString = date.toISOString().split('T')[0];
                    const isDisabled = date < new Date().setHours(0, 0, 0, 0);
                    const isActive = selectedDate && date.toDateString() === selectedDate.toDateString();
        
                    html += `<div class="calendar-day${isDisabled ? ' disabled' : ''}${isActive ? ' active' : ''}" data-date="${date.toISOString()}">${day}</div>`;
                }
        
                $('#calendarGrid').html(html);
                $('#currentMonth').text(`${monthNames[month]} ${year}`);
            }
        
            function generateTimeSlots(date) {
                const dayOfWeek = date.getDay(); 
                const dayName = dayNames[dayOfWeek].toLowerCase(); 
                const isDayEnabled = scheduleData[`${dayName}_enabled`];
                let html = '';
                const dateString = date.toISOString().split('T')[0];
        
                // Check for holidays
                const holiday = holidays.find(holiday => holiday.date.split('T')[0] === dateString);
                const isHoliday = !!holiday;
                const isFullDayHoliday = isHoliday && holiday.start_time === null;
                const holidayStart = isHoliday && holiday.start_time ? new Date(`${holiday.date.split('T')[0]}T${holiday.start_time}`) : null;
                const holidayEnd = isHoliday && holiday.end_time ? new Date(`${holiday.date.split('T')[0]}T${holiday.end_time}`) : null;
        
                if (isFullDayHoliday || !isDayEnabled) {
                    html = '<div class="text-center text-muted">Closed</div>';
                    $('#submitBtn').prop('disabled', true); // Disable "Book Now" button
                } else {
                    const startTime = scheduleData[`${dayName}_start_time`];
                    const endTime = scheduleData[`${dayName}_end_time`];
                    const timeSlots = getTimeSlotsBetween(startTime, endTime);
        
                    let availableTimeSlots = timeSlots.filter(time => {
                        const timeDate = new Date(`${dateString}T${time}`);
                        return !holidayStart || timeDate < holidayStart || timeDate > holidayEnd;
                    });
        
                    if (availableTimeSlots.length === 0) {
                        html = '<div class="text-center text-muted">Closed</div>';
                        $('#submitBtn').prop('disabled', true); // Disable "Book Now" button
                    } else {
                        availableTimeSlots.forEach(time => {
                            html += `
                                <button type="button" class="time-slot" data-time="${time}">
                                    ${time}
                                </button>`;
                        });
                        $('#submitBtn').prop('disabled', false); // Enable "Book Now" button
                    }
                }
        
                $('#timeSlotContainer').html(html);
                $('#selectedDate').text(date.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }));
                $("#timebox").removeClass('d-none');
            }
        
            function getTimeSlotsBetween(startTime, endTime) {
                const timeSlots = [];
                let start = parseTime(startTime);
                const end = parseTime(endTime);
        
                while (start.hours < end.hours || (start.hours === end.hours && start.minutes < end.minutes)) {
                    timeSlots.push(formatTime(start));
                    start = incrementTime(start);
                }
        
                return timeSlots;
            }
        
            function parseTime(time) {
                const [hours, minutes] = time.split(':').map(num => parseInt(num));
                return { hours, minutes };
            }
        
            function formatTime(time) {
                return `${padTime(time.hours)}:${padTime(time.minutes)}`;
            }
        
            function padTime(num) {
                return num < 10 ? `0${num}` : `${num}`;
            }
        
            function incrementTime(time) {
                let { hours, minutes } = time;
                hours += 1;
                return { hours, minutes };
            }
        
            $(document).on('click', '.calendar-day:not(.disabled)', function() {
                $('.calendar-day').removeClass('active');
                $(this).addClass('active');
                selectedDate = new Date($(this).data('date'));
        
                const userId = @json($userID);
                fetchSchedule(userId).then(() => {
                    generateTimeSlots(selectedDate);
                });
            });
        
            $(document).on('click', '.time-slot', function() {
                $('.time-slot').removeClass('selected');
                $(this).addClass('selected');
                selectedTime = $(this).data('time');
            });
        
            $('#submitBtn').click(function(event) {
                event.preventDefault();
        
                if (!selectedDate || !selectedTime) {
                    alert('Please select a valid date and time!');
                    return;
                }
        
                $('#selectedDateInput').val(selectedDate);
                $('#selectedTimeInput').val(selectedTime);
                $('#appointmentForm').submit();
            });
        
            const userId = @json($userID);
            fetchSchedule(userId).then(() => {
                generateCalendar(new Date().getFullYear(), new Date().getMonth());
            });
        });
        </script>
        
</body>
</html>
