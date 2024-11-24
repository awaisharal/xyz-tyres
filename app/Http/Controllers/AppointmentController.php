<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Appointment;

class AppointmentController extends Controller
{

    public function create(Service $service)
    
    {
        $customer = Auth::guard('customer')->user();
        $customer = Auth::guard('customer')->user();
        return view('customer.appointments.create', compact('customer','service'));
    }

    public function store(Request $request, Service $service)
    {
        $customer = Auth::guard('customer')->user();
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
        ]);

        Appointment::create([
            'service_id' => $service->id,
            'customer_id' => $customer->id,
            'date' => $request->date,
            'time' => $request->time,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
        ]);

        return redirect()->route('customer.appointments.index')->with('success', 'Appointment booked successfully!');
    }
        
}
