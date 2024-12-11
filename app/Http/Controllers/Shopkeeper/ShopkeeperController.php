<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Support\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;


class ShopkeeperController extends Controller
{
    public function dashboard(Request $request)
    {
        $shopkeeperId = auth()->id(); // Assuming shopkeeper is authenticated
    
        // Get the selected period from the request, defaulting to 'monthly'
        $period = $request->get('period', 'monthly');
    
        // Fetch all services provided by this shopkeeper
        $services = Service::where('user_id', $shopkeeperId)->pluck('id');
    
        // Define the start of each period
        $today = now()->startOfDay();
        $weekStart = now()->startOfWeek();
        $monthStart = now()->startOfMonth();
    
        // Apply the selected period filter for all cards
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
    
       
        $totalAppointments = Appointment::whereIn('service_id', $services)
            ->whereBetween(DB::raw("CONCAT(date, ' ', time)"), $this->getDateTimeRange($period)) // Combine date and time
            ->count();

        // Upcoming Appointments: Considering both date and time
        $upcomingAppointments = Appointment::whereIn('service_id', $services)
            ->where(DB::raw("CONCAT(date, ' ', time)"), '>=', Carbon::now()->format('Y-m-d H:i:s')) // Combine date and time, compare with now
            ->count();

            // return $upcomingAppointments;


            // Free Appointments
        $freeAppointments = Appointment::whereIn('service_id', $services)
        ->where('payment_status', 'free')
        ->whereBetween('date', $this->getDateTimeRange($period))
        ->count();
    
        // Total Services Listed
        $totalServicesListed = Service::where('user_id', $shopkeeperId)->count();
    
        // Most Booked Service
        $mostBookedService = Service::whereIn('id', $services)
            ->withCount('appointments')
            ->orderBy('appointments_count', 'desc')
            ->first();
            // $time =now();
            // return $time;
    
        // Pass all the data to the dashboard view
        return view('shopkeeper.dashboard', compact(
            'totalServicesListed',
            'mostBookedService',
            'sales',
            'totalAppointments',
            'freeAppointments',
            'upcomingAppointments',
            'period'
        ));
    }
    
    // Helper function to determine the date range for each period
    private function getDateTimeRange($period)
    {
        $now = now(); // Current datetime
        $todayStart = now()->startOfDay();
        $weekStart = now()->startOfWeek();
        $monthStart = now()->startOfMonth();

        return match ($period) {
            'daily' => [$todayStart, $now], // Start of today to now
            'weekly' => [$weekStart, $now], // Start of week to now
            'monthly' => [$monthStart, $now], // Start of month to now
            default => [$monthStart, $now], // Default to month if period is unknown
        };
    }

    
    
    


public function getSalesData(Request $request)
{
    $shopkeeperId = auth()->id();
    $services = Service::where('user_id', $shopkeeperId)->pluck('id');

    $period = $request->get('period'); // Expecting 'daily', 'weekly', or 'monthly'
    $today = now()->startOfDay();
    $weekStart = now()->startOfWeek();
    $monthStart = now()->startOfMonth();

    // Define period-specific queries
    $dateRange = match ($period) {
        'daily' => [$today, $today],
        'weekly' => [$weekStart, now()],
        'monthly' => [$monthStart, now()],
        default => [$monthStart, now()],
    };

    // Sales Data
    $sales = Appointment::whereIn('service_id', $services)
        ->whereBetween('date', $dateRange)
        ->join('services', 'appointments.service_id', '=', 'services.id')
        ->sum('services.price');

    // Total Appointments
    $totalAppointments = Appointment::whereIn('service_id', $services)
        ->whereBetween('date', $dateRange)
        ->count();

    // Free Appointments
    $freeAppointments = Appointment::whereIn('service_id', $services)
        ->where('payment_status', 'free')
        ->whereBetween('date', $dateRange)
        ->count();

    // Upcoming Appointments
    $upcomingAppointments = Appointment::whereIn('service_id', $services)
        ->whereDate('date', '>=', now())
        ->whereBetween('date', $dateRange)
        ->count();

    return response()->json([
        'sales' => $sales,
        'totalAppointments' => $totalAppointments,
        'freeAppointments' => $freeAppointments,
        'upcomingAppointments' => $upcomingAppointments,
    ]);
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

