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
        if (Auth::guard('customers')->check()) {    
            Auth::guard('customers')->logout(); // Log out the customer
        }
        Toastr::success('logged out successfully.');
        return redirect ('customer/login');
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
    public function showAppointments()
    {
        $customer = Auth::guard('customers')->user();

        if (!$customer) {
            Toastr::error('You must be logged in to view your appointments.');
            return redirect()->route('customer.login');
        }

        $appointments = Appointment::where('customer_id', $customer->id)
            ->with('service.user') 
            ->get();

       

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

    public function showPayments(){

        $customer = Auth::guard('customers')->user();
        if (!$customer) {
            return redirect()->route('customer.login')->with('error', 'Please login to view your payments.');
        }
        $payments = Payment::where('payments.customer_id', $customer->id)
            ->with(['appointment', 'appointment.service'])
            ->select(
                'payments.id',
                'payments.amount',
                'payments.payment_status',
                'payments.transaction_id',
                'appointments.date as appointment_date',
                'services.name as service_name' 
            )
            ->join('appointments', 'payments.appointment_id', '=', 'appointments.id')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->get();
    
            return view('customer.payments.index', compact('payments'));
    
            return $payments;
        
    }
}
