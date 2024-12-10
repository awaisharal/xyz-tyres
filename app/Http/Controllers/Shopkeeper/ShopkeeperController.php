<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;


class ShopkeeperController extends Controller
{
    public function showAppointments()
    {
    
    $shopkeeper = Auth::user();
    if (!$shopkeeper) {
       
        Toastr::error('You must be logged in to view appointments.');
        return redirect()->route('login');
    }
    $appointments = Appointment::with(['service', 'service.user', 'customer'])
    ->whereHas('service', function ($query) use ($shopkeeper) {
        $query->where('user_id', $shopkeeper->id);
    })->get();
    //  return $appointments;


    return view('shopkeeper.appointments.index', compact('appointments'));
    }
}

