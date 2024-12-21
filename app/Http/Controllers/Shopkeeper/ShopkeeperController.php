<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Payment;
use App\Models\User;
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

            // $slug= Auth::user()->company_slug;
            // return $slug;
    
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

    
    public function showAppointments(Request $request)
    {
        $shopkeeper = Auth::user();
    
        if (!$shopkeeper) {
            Toastr::error('You must be logged in to view appointments.');
            return redirect()->route('login');
        }
    
        $query = Appointment::with(['service', 'service.user', 'customer'])
            ->whereHas('service', function ($query) use ($shopkeeper) {
                $query->where('user_id', $shopkeeper->id);
            });
    
        if ($request->has('search') && $request->search) {
            $key = explode(' ', $request->search);
            $query->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhereHas('customer', function ($customerQuery) use ($value) {
                        $customerQuery->where('name', 'like', "%{$value}%")
                                     ->orWhere('email', 'like', "%{$value}%");
                    })
                    ->orWhereHas('service', function ($serviceQuery) use ($value) {
                        $serviceQuery->where('title', 'like', "%{$value}%")
                                     ->orWhereHas('user', function ($userQuery) use ($value) {
                                         $userQuery->where('company', 'like', "%{$value}%");
                                     });
                    })
                    ->orWhere('date', 'like', "%{$value}%")
                    ->orWhere('payment_status', 'like', "%{$value}%");
                }
            });
        }
    
        $appointments = $query->paginate(10)->appends(['search' => $request->search]);
    
        return view('shopkeeper.appointments.index', compact('appointments'));
    }
        

    public function showCustomers(Request $request)
    {
        $query = Appointment::with('customer') // Load customer relationship
            ->whereHas('service', function ($query) {
                $query->where('user_id', auth()->id()); // Filter appointments by shopkeeper
            });
    
        // Apply search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('customer', function ($customerQuery) use ($search) {
                $customerQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhere('phone', 'like', "%{$search}%");
        }
    
        // Group and aggregate customer details with counts
        $customers = $query->get()
            ->groupBy('customer_id')
            ->map(function ($appointments) {
                $customer = $appointments->first()->customer; // Get the customer details
                return [
                    'customer' => $customer,
                    'phone' => $appointments->first()->phone, // Fetch phone number from the appointment
                    'appointment_count' => $appointments->count(), // Count total appointments for this customer
                ];
            });
    
        return view('shopkeeper.customers.index', compact('customers'));
    }
    
    

    public function showPayments(Request $request)
    {
        $query = Payment::with(['appointment.customer', 'appointment.service'])
            ->whereHas('appointment.service', function ($query) {
                $query->where('user_id', auth()->id()); // Filter by shopkeeper's user ID
            })
            ->join('appointments', 'payments.appointment_id', '=', 'appointments.id')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->select(
                'payments.id',
                'payments.amount',
                'payments.payment_status',
                'payments.transaction_id',
                'appointments.customer_id',
                'appointments.service_id',
                'appointments.id as appointment_id',
                'appointments.date as appointment_date',
                'services.title as service_name' // Include service name for search and display
            );
    
        // Apply search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('payments.transaction_id', 'like', "%{$search}%")
                  ->orWhere('payments.payment_status', 'like', "%{$search}%")
                  ->orWhere('appointments.date', 'like', "%{$search}%")
                  ->orWhere('services.title', 'like', "%{$search}%") // Search by service name
                  ->orWhereHas('appointment.customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
    
        $payments = $query->get();
    
        return view('shopkeeper.payments.index', compact('payments'));
    }
    
    

    public function showBookingWidget($company_slug)
    {
        // $services = Service::where('user_id', Auth::id())->get(); 
        $user = User::where('company_slug', $company_slug)->firstOrFail();
        $services = Service::where('user_id', $user->id)->get();      
        // $user=Auth::user(); 
       

        // $user = User::where('company_slug', $company_slug)->firstOrFail();
        $company_slug=$user->company_slug;  
        // return $company_slug;                                                
        return view('shopkeeper.booking-widget', compact('user', 'services','company_slug'));
    }

}

