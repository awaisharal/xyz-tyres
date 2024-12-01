<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Appointment;
use DateTime;

class AppointmentController extends Controller
{

    public function create(Service $service)
    
    {
        $customer = Auth::guard('customers')->user();
        $user = $service->user;

        
        return view('customer.appointments.create', compact('user','customer','service'));
    }




public function store(Request $request, Service $service)
{
    $customer = Auth::guard('customers')->user();

    // Validate the incoming request
    $request->validate([
        'date' => 'required|date|after_or_equal:today',
        'time' => 'required|string', // Ensure time is provided as string
        
    ]);

    // Convert the time from 12-hour format (e.g., '7:30pm') to 24-hour format (e.g., '19:30:00')
    $time24 = DateTime::createFromFormat('h:ia', $request->time)->format('H:i:s');

    // Create the appointment record
    Appointment::create([
        'service_id' => $service->id,
        'customer_id' => $customer->id,
        'date' => $request->date,
        'time' => $time24, 
        
    ]);

    return redirect()->route('customer.appointments.index')->with('error', 'Appointment booked successfully!');

}


    // public function store(Request $request, Service $service)
    // {
    //     $customer = Auth::guard('customers')->user();
    //     $request->validate([
    //         'date' => 'required|date|after_or_equal:today',
    //         'time' => 'required',
    //         'customer_name' => 'required|string|max:255',
    //         'customer_email' => 'required|email',
    //     ]);
        

    //     Appointment::create([
    //         'service_id' => $service->id,
    //         'customer_id' => $customer->id,
    //         'date' => $request->date,
    //         'time' => $request->time,
    //         'customer_name' => $request->customer_name,
    //         'customer_email' => $request->customer_email,
    //     ]);

    //     return redirect()->route('customer.appointments.index')->with('success', 'Appointment booked successfully!');
    // }
        
}


