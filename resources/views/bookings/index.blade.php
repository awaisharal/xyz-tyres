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
    </style>
</head>
<body >
    <div class="booking-container">
        <div class="row g-0">
            <!-- Left Sidebar -->
            <div class="col-md-4 event-details">
                <div class="event-icon">
                    <i class="fs-4">E</i>
                </div>
                <h6 class="text-muted mb-2">Eastlancers</h6>
                <h4 class="mb-4">Web Design Services</h4>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-clock me-2"></i>
                        <span class="fw-bold">$60</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="far fa-clock me-2"></i>
                        <span>5 Hours</span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-camera-video me-2"></i>
                    <span class="text-muted">
                        We can bring your web design vision and ideas to life through innovative custom design for your business. We work on hundreds of websites a year, and bring unique insight from our deep experience.
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
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/js/all.min.js" integrity="sha512-1JkMy1LR9bTo3psH+H4SV5bO2dFylgOy+UJhMus1zF4VEFuZVu5lsi4I6iIndE4N9p01z1554ZDcvMSjMaqCBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            const dayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
            let currentDate = new Date();
            let selectedDate = null;

            function generateCalendar(year, month) {
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                let html = '';

                // Add day names
                dayNames.forEach(day => {
                    html += `<div class="text-center text-muted">${day}</div>`;
                });

                // Add empty cells for days before the first day of the month
                for (let i = 0; i < firstDay.getDay(); i++) {
                    html += '<div></div>';
                }

                // Add calendar days
                for (let day = 1; day <= lastDay.getDate(); day++) {
                    const date = new Date(year, month, day);
                    const isDisabled = date < new Date().setHours(0, 0, 0, 0);
                    const isActive = selectedDate && date.toDateString() === selectedDate.toDateString();
                    html += `<div class="calendar-day${isDisabled ? ' disabled' : ''}${isActive ? ' active' : ''}" data-date="${date.toISOString()}">${day}</div>`;
                }

                $('#calendarGrid').html(html);
                $('#currentMonth').text(`${monthNames[month]} ${year}`);
            }

            function generateTimeSlots(date) {
                const timeSlots = ['7:30pm', '8:00pm', '8:30pm', '9:00pm', '9:30pm', '10:00pm', '10:30pm', '11:00pm'];
                let html = '';
                timeSlots.forEach(time => {
                    html += `<a href="/book/eastlancers/${date}-${time}" class="time-slot">${time}</a>`;
                });
                $('#timeSlotContainer').html(html);
                $('#selectedDate').text(date.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }));
                $("#timebox").removeClass('d-none');
            }

            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());

            $('#prevMonth').click(function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
            });

            $('#nextMonth').click(function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
            });

            $(document).on('click', '.calendar-day:not(.disabled)', function() {
                $('.calendar-day').removeClass('active');
                $(this).addClass('active');
                selectedDate = new Date($(this).data('date'));
                generateTimeSlots(selectedDate);
            });
        });
    </script>
</body>
</html>
