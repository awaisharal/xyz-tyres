<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class ShopkeeperController extends Controller
{
    public function showAppointments()
    {
    
    $shopkeeper = Auth::user();
    if (!$shopkeeper) {
       
        return redirect()->route('login')->with('error', 'You must be logged in to view appointments.');
    }
    $appointments = Appointment::with(['service', 'service.user'])
        ->whereHas('service', function ($query) use ($shopkeeper) {
            $query->where('user_id', $shopkeeper->id);
        })
        ->get();

    return view('shopkeeper.appointments.index', compact('appointments'));
    }
}

