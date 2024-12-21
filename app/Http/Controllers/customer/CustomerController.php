<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Payment;
use App\Models\Appointment;
use Brian2694\Toastr\Facades\Toastr;


class CustomerController extends Controller
{
    public function register_view()
    {
        return view ('customer.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:8|max:255|confirmed',
        ]);
    
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        Auth::guard('customers')->login($customer);
    
        return redirect()->route('customer.dashboard');
    }
  
    public function login_view()
    {
        return view ('customer.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        
        if (Auth::guard('customers')->attempt(['email' => $request->email, 'password' => $request->password])) {
            Toastr::success('Log in Successfully!.');
            return redirect()->route('customer.dashboard');
        }
        Toastr::error('Invalid credentials.');
        return back();
    }

    public function logout(Request $request)
    {
        // $auth = Auth::guard('customers')->check();
        if (Auth::guard('customers')->check()) {    
            Auth::guard('customers')->logout(); 
            // Log out the customer

      
        }
        Toastr::success('logged out successfully.');
        return redirect ('/customer/login');
    }

    public function dashboard(){
        $customer = Auth::guard('customers')->user();
        $services = Service::with('user')->get();

        return view('customer.dashboard', compact('customer'));
    }
    public function showServices(){

        
        $customer = Auth::guard('customers')->user();
        $services = Service::with('user')->get();
        
       
        return view('customer.services', compact('customer', 'services'));
    }
    public function showAppointments(Request $request)
    {
        $customer = Auth::guard('customers')->user();
    
        if (!$customer) {
            Toastr::error('You must be logged in to view your appointments.');
            return redirect()->route('customer.login');
        }
    
        $query = Appointment::where('customer_id', $customer->id)
            ->with('service.user');
    
        if ($request->has('search') && $request->search) {
            $key = explode(' ', $request->search);
            $query->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhereHas('service', function ($serviceQuery) use ($value) {
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
    
        return view('customer.appointments.index', compact('customer', 'appointments'));   
    }
    


//////////////////////profile section /////////////////////


    
    public function edit(Request $request)
    {
        $customer = Auth::guard('customers')->user();
        return view('customer.profile.edit', compact('customer'));
    }

    
    public function update(Request $request)
    {
        $customer = Auth::guard('customers')->user(); 
        if (!($customer instanceof Customer)) 
        {
            Toastr::error('Customer not found.');
            return redirect()->route('customer.profile.edit');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $customer->id,
        ]);
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');

        if ($request->has('password') && $request->input('password')) {
            $customer->password = Hash::make($request->input('password'));
        }

         $customer->save();

         Toastr::success('Updated successfully');
         return back(); 

    }

    
    public function editPassword()
    {
        return view('customer.profile.password');
    }

   
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $customer = Auth::guard('customers')->user(); 

        
        if (!($customer instanceof Customer)) {
            Toastr::error('Customer not found.');
            return redirect()->route('customer.profile.edit');
        }

        
        if (!Hash::check($request->input('current_password'), $customer->password)) {
            Toastr::error('Current password is incorrect.');
            return back();
        }

        
        $customer->password = Hash::make($request->input('password'));
        $customer->save();
        Toastr::success('Password updated successfully.');
        return redirect()->route('customer.profile.edit')->with('success', 'Password updated successfully.');
    }
    public function destroy(Request $request)
    {
        
        if (!$request->has('confirm_delete')) {
            Toastr::error('You must confirm the deletion of your account.');
            return redirect()->back();
        }

        // Get the logged-in customer
        $customer = Auth::customer();

        
        $customer->delete();

       
        Auth::logout();
        Toastr::success('Your account has been deleted.');

        
        return redirect()->route('customer/register');
    }

    public function showPayments(Request $request)
    {
        $customer = Auth::guard('customers')->user();
    
        if (!$customer) {
            return redirect()->route('customer.login')->with('error', 'Please login to view your payments.');
        }
    
        $query = Payment::where('payments.customer_id', $customer->id)
            ->with(['appointment.service.user']); // Eager load the relationships
    
        // Apply search filter if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
    
            $query->where(function ($query) use ($search) {
                $query->whereHas('appointment.service.user', function ($q) use ($search) {
                    $q->where('company', 'like', '%' . $search . '%');
                })
                ->orWhereHas('appointment.service', function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%');
                })
                ->orWhere('payments.payment_status', 'like', '%' . $search . '%')
                ->orWhereHas('appointment', function ($q) use ($search) {
                    $q->whereDate('appointments.date', 'like', '%' . $search . '%');
                })
                ->orWhere('payments.transaction_id', 'like', '%' . $search . '%');  // Search by transaction_id
            });
        }
    
        $payments = $query->get();
    
        return view('customer.payments.index', compact('payments'));
    }
    

    
}
