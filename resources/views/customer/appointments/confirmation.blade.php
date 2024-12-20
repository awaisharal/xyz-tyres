<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

       
        .event-details .backbtn{
            border: 1px solid #efefef;
            background: #efefef;
            border-radius: 100px;
            display: flex;
            justify-content: center;
            align-content: center;
            padding: 8px;
        }
        .bookingForm{
            margin-top: 30px
        }
        .bookingForm .form-group{
            margin-bottom: 15px
        }
        .bookingForm label{
            font-weight: 500;
            color: #000;
            margin-bottom: 4px;
        }
        .bookingForm input{
            height: 45px;
            border: 1px solid #ccc;
            box-shadow: none!important;
        }
        .bookBtn{
            border-color: #006bff;
            background: #006bff;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
            padding: 8px 16px;
            min-height: 44px;
            border-radius: 100px;
            margin-top: 30px;
        }
        .bookBtn:hover{
            background: #004eba;
            border: 1px solid #004eba;
        }
    </style>
</head>
<body >
    <div class="booking-container">
        <div class="row g-0">
            <!-- Left Sidebar -->
            <div class="col-md-4 event-details">
                <div class="mb-5">
                    <a href={{route('customer.appointment.create',['service' => $service->id, 'company_slug' => $service->user->company_slug])}}>
                        <button class="backbtn">
                            <i class="fa fa-arrow-left fa-lg"></i>
                        </button>
                    </a>
                </div>
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

                        {{-- We can bring your web design vision and ideas to life through innovative custom design for your business. We work on hundreds of websites a year, and bring unique insight from our deep experience. --}}
                    </span>
                </div>
            </div>

            <!-- Main Calendar Area -->
            <div class="col-md-6 position-relative p-5">
                <h5>Enter Details</h5>
                <form action="{{route('customer.store.appointment')}}" method="POST" class="bookingForm">
                    @csrf
                    <div>
                        <h1>Appointment Confirmation</h1>
                        <input type="hidden" name="date" id="date" value="{{ request('date') }}">
                        <input type="hidden" name="time" id="time" value="{{ request('time') }}">
                        <input type="hidden" name="service" value="{{ $service->id }}">
                    </div>                   
                
                    @php
                        $isLoggedIn = Auth::guard('customers')->check();
                        $customer = $isLoggedIn ? Auth::guard('customers')->user() : null;
                    @endphp
                
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="eg. Name" 
                            value="{{ old('name', $customer->name ?? '') }}" 
                            {{ $isLoggedIn ? 'readonly' : 'required' }} />
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="eg. example@example.com" 
                            value="{{ old('email', $customer->email ?? '') }}" 
                            {{ $isLoggedIn ? 'readonly' : 'required' }} />
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
                    @if (!$isLoggedIn)
                    <div class="form-group d-none" id="passwordGroup">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="xxxxxxxx" required />
                            <button type="button" id="verifyPasswordButton" class="btn btn-outline-success">
                                <i class="fas fa-check" id="verifyPasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group d-none" id="confirmPasswordGroup">
                        <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="xxxxxxxx" required />
                            <button type="button" id="verifyConfirmPasswordButton" class="btn btn-outline-success">
                                <i class="fas fa-check" id="verifyConfirmPasswordIcon"></i>
                            </button>
                        </div>
                        @error('confirm_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif
                
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="number" name="phone" id="phone" class="form-control" placeholder="eg. 999-999-9999" value="{{ old('phone') }}" required />
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
                    @if($service->is_additional_info === 1)
                    <div class="form-group">
                        <label for="additional_info">{{ $service->additional_info }} <span class="text-danger">*</span></label>
                        <textarea name="additional_info" class="form-control" placeholder="Enter additional info..." rows="3">{{ old('additional_info') }}</textarea>
                        @error('additional_info')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif
                
                    <div class="form-group">
                        <small>
                            By clicking the below button you will be redirected to the payments page.
                        </small>
                    </div>
                
                    <div class="form-group">
                        <button type="submit" class="bookBtn">Book Appointment</button>
                    </div>
                </form>
                
            </div>
            {{-- <div class="col-md-2"></div> --}}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/js/all.min.js" integrity="sha512-1JkMy1LR9bTo3psH+H4SV5bO2dFylgOy+UJhMus1zF4VEFuZVu5lsi4I6iIndE4N9p01z1554ZDcvMSjMaqCBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.getElementById('email').addEventListener('blur', () => {
            const email = document.getElementById('email').value.trim(); // Trim to avoid extra spaces
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
            if (!email) {
                return;
            }
    
            fetch('/check/user-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ email: email }),
            })
            .then(response => {
                return response.json(); 
            })
            .then(data => {
                const passwordFieldGroup = document.getElementById('passwordGroup');
                const passwordField = document.getElementById('password');
                const confirmPasswordFieldGroup = document.getElementById('confirmPasswordGroup');
                const confirmPasswordField = document.getElementById('confirm_password');
    
                if (data.exists) {
                    passwordFieldGroup.classList.remove('d-none');
                    confirmPasswordFieldGroup.classList.add('d-none');
                    passwordField.setAttribute('required', 'true');
                    confirmPasswordField.removeAttribute('required');
                    confirmPasswordField.removeAttribute('name');
                } else {
                    passwordFieldGroup.classList.remove('d-none');
                    confirmPasswordFieldGroup.classList.remove('d-none');
                    passwordField.setAttribute('required', 'true');
                    confirmPasswordField.setAttribute('required', 'true');
                    confirmPasswordField.setAttribute('name', 'confirm_password');
                }
            })
            .catch(error => {
                console.error("Error during fetch:", error);
            });
        });
    
        document.getElementById('verifyPasswordButton').addEventListener('click', function () {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password') ? document.getElementById('confirm_password').value : null;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            let url = '/login/validate';
            let method = 'POST';
            let body = JSON.stringify({ email: email, password: password });
    
            if (confirmPassword) {
                url = '/register/validate';
                body = JSON.stringify({ name: name, email: email, password: password, confirm_password: confirmPassword });
            }
    
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: body,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (confirmPassword) {
                        // Handle successful registration
                        document.getElementById('password').classList.add('is-valid'); // Green outline for password
                        document.getElementById('confirm_password').classList.add('is-valid'); // Green outline for confirm password
                        document.getElementById('verifyConfirmPasswordIcon').classList.add('bg-success'); // Green background on tick mark for confirm password
                        document.getElementById('passwordGroup').classList.add('d-none');
                        document.getElementById('confirmPasswordGroup').classList.add('d-none');
                        
                        alert('Registration successful! You can now proceed with booking.');
                    } else {
                        // Handle successful login
                        document.getElementById('password').classList.add('is-valid'); // Green outline for password
                        document.getElementById('verifyPasswordIcon').classList.add('bg-success'); // Green background on tick mark for password
                        document.getElementById('passwordGroup').classList.add('d-none');
                        document.getElementById('email').disabled = true;
                        document.getElementById('name').disabled = true;
                        alert('Login successful! You can now proceed with booking.');
                    }
    
                    // Disable email and name fields
                    document.getElementById('email').disabled = true;
                    document.getElementById('name').disabled = true;
    
                    // Disable password field after login or registration
                    document.getElementById('password').disabled = true;
                    // Disable the tick mark button after success
                    document.getElementById('verifyPasswordButton').disabled = true;
                    document.getElementById('verifyConfirmPasswordButton').disabled = true;
                } else {
                    if (confirmPassword) {
                        document.getElementById('confirm_password').classList.add('is-invalid'); // Red outline for confirm password
                    } else {
                        document.getElementById('password').classList.add('is-invalid'); // Red outline for password
                    }
                    alert('Invalid credentials or passwords do not match');
                }
            })
            .catch(error => {
                console.error('Error during validation:', error);
            });
        });
    </script>
    
</body>
</html>
