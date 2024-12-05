<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login_view()
    {
        return view('admin.login');
    }
    public function login(Request $request)
    {
        // return $request;
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard');
        }
        
        return back()->withErrors(['email' => 'Invalid Credentials.']);
    }
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.dashboard',compact('admin'));
    }
    public function CustomerList()
    {
        $customers = Customer::select('id','name','email')->get();
        return view('admin.customer',compact('customers'));
    }
    public function ShopList()
    {
        $shopkeepers = User::select('id','name','email','company')->get();
        return view('admin.shopkeeper',compact('shopkeepers'));
    }
    public function AppointmentList()
    {
        $appointments = Appointment::with('service','customer')->get()->all();
        return view('admin.appointment',compact('appointments'));
    }
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        return redirect('admin/login')->with('success', 'logged out successfully.');
    }
    public function CustomerDestroy(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('admin.customer.list')->with('success','Deleted Successfully');
        
        
    }
    public function ShopkeeperDestroy($id)
    {
        $shopkeepers = User::findorFail($id);
        $shopkeepers->delete();
        return redirect()->route('admin.shopkeeper.list')->with('success','Deleted Successfully');
    }
    public function AppointmentDestroy($id)
    {
        $appointments = Appointment::findorFail($id);
        $appointments->delete();
        return redirect()->route('admin.appointment.list')->with('success','Deleted Successfully');
    }
}