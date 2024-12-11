<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;

use Brian2694\Toastr\Facades\Toastr;


class ShopkeeperController extends Controller
{
    public function dashboard()
    {

       
        $shopkeeperId = auth()->id(); // Assuming shopkeeper is authenticated

        // Fetch all services provided by this shopkeeper
        $services = Service::where('user_id', $shopkeeperId)->pluck('id');

        // Total Services Listed
        $totalServicesListed = $services->count();

        // Title of the Most Booked Service
        $mostBookedService = Service::where('user_id', $shopkeeperId)
            ->withCount('appointments')
            ->orderBy('appointments_count', 'desc')
            ->first();

        // Sales Data
        $today = now()->startOfDay();
        $weekStart = now()->startOfWeek();
        $monthStart = now()->startOfMonth();

        $sales = [
            'daily' => Appointment::whereIn('service_id', $services)
                ->whereDate('date', $today)
                ->join('services', 'appointments.service_id', '=', 'services.id')
                ->sum('services.price'),
            'weekly' => Appointment::whereIn('service_id', $services)
                ->whereBetween('date', [$weekStart, now()])
                ->join('services', 'appointments.service_id', '=', 'services.id')
                ->sum('services.price'),
            'monthly' => Appointment::whereIn('service_id', $services)
                ->whereBetween('date', [$monthStart, now()])
                ->join('services', 'appointments.service_id', '=', 'services.id')
                ->sum('services.price'),
        ];

        // Total Appointments
        $totalAppointments = Appointment::whereIn('service_id', $services)->count();

        // Free Appointments
        $freeAppointments = Appointment::whereIn('service_id', $services)
            ->where('payment_status', 'free')
            ->count();

        // Upcoming Appointments
        $upcomingAppointments = Appointment::whereIn('service_id', $services)
            ->whereDate('date', '>=', now())
            ->count();

            

        // Pass all the data to the dashboard view
        return view('shopkeeper.dashboard', compact(
            'totalServicesListed',
            'mostBookedService',
            'sales',
            'totalAppointments',
            'freeAppointments',
            'upcomingAppointments'
        ));
    }

    public function getSalesData(Request $request)
    {
        $shopkeeperId = auth()->id();
        $services = Service::where('user_id', $shopkeeperId)->pluck('id');

        $period = $request->get('period'); // Expecting 'daily', 'weekly', or 'monthly'
        $today = now()->startOfDay();
        $weekStart = now()->startOfWeek();
        $monthStart = now()->startOfMonth();
       
    
        

        $sales = match ($period) {
            'daily' => Appointment::whereIn('service_id', $services)
                ->whereDate('date', $today)
                ->join('services', 'appointments.service_id', '=', 'services.id')
                ->sum('services.price'),
            'weekly' => Appointment::whereIn('service_id', $services)
                ->whereBetween('date', [$weekStart, now()])
                ->join('services', 'appointments.service_id', '=', 'services.id')
                ->sum('services.price'),
            'monthly' => Appointment::whereIn('service_id', $services)
                ->whereBetween('date', [$monthStart, now()])
                ->join('services', 'appointments.service_id', '=', 'services.id')
                ->sum('services.price'),
            default => 0
        };

        return response()->json(['sales' => $sales]);
    }
    
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

