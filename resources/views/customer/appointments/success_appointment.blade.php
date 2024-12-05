<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Payment</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to right, #e6f2ff, #b3d9ff); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg" style="border-radius: 15px;">
                    <div class="card-body text-center p-5">
                        <div class="mb-4" style="background-color: #d4edda; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="bi bi-check-circle" style="font-size: 2.5rem; color: #28a745;"></i>
                        </div>
                        <h1 class="card-title mb-3" style="font-size: 2.5rem; color: #333;">Thank You for Your Payment!</h1>
                        <p class="card-text mb-4" style="font-size: 1.2rem; color: #666;">Your transaction was successful.</p>
                        
                        <div class="mt-5">
                            <h2 class="mb-4" style="font-size: 1.5rem; color: #444;">Transaction Details</h2>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        {{-- <tr>
                                            <th scope="row" class="text-start" style="color: #666;">Order ID:</th>
                                            <td class="text-end" style="color: #333;"></td>
                                        </tr> --}}
                                        <tr>
                                            <th scope="row" class="text-start" style="color: #666;">Transaction ID:</th>
                                            <td class="text-end" style="color: #333;">{{$transactionId}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start" style="color: #666;">Amount:</th>
                                            <td class="text-end" style="color: #333;">${{$amountPaid}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start" style="color: #666;">Payment Date:</th>
                                            <td class="text-end" style="color: #333;">{{$paymentDate}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start" style="color: #666;">Appointment Date:</th>
                                            <td class="text-end" style="color: #333;">{{$appointmentDate}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-start" style="color: #666;">Customer Name:</th>
                                            <td class="text-end" style="color: #333;">{{$appointmentData->customer->name}}</td>
                                        </tr>
                                        {{-- <tr>
                                            <th scope="row" class="text-start" style="color: #666;">Payment Method:</th>
                                            <td class="text-end" style="color: #333;">Credit Card (****1234)</td>
                                        </tr> --}}
                                        <tr>
                                            <th scope="row" class="text-start" style="color: #666;">Service Booked:</th>
                                            <td class="text-end" style="color: #333;">{{$appointmentData->service->title}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <p class="mt-5 mb-4" style="color: #666;">Thank you for booking with us! We appreciate your payment and look forward to serving you.</p>
                        <a href="{{route('customer.appointments.index')}}" class="btn btn-primary btn-lg" style="background-color: #007bff; border-color: #007bff;">
                            <i class="bi bi-arrow-left me-2"></i>Return to Appointments
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, only needed if you require Bootstrap's JavaScript features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

