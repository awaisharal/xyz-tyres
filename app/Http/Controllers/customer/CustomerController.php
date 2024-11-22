<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Service;

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
    
        Auth::guard('customer')->login($customer);
    
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
    
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('customer.dashboard');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        
    }

    public function dashboard(){
        $customer = Auth::guard('customer')->user();
        $services = Service::with('user')->get();

        return view('customer.dashboard', compact('customer'));
    }
    public function showServices(){
        $customer = Auth::guard('customer')->user();
        $services = Service::with('user')->get();
       
        return view('customer.services', compact('customer', 'services'));
    }
}

