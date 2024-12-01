<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function booking_page()
    {
        return view('bookings.index');
    }

    public function booking_confirmation_page()
    {
        return view('bookings.confirmation');
    }
}
