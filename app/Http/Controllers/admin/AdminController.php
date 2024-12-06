<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\User;
use App\Models\ServiceProvider;
use App\Models\Service;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Log;

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
    public function ShopList(Request $request)
    {
        $shopkeepers = User::select('id','name','email','company');
        $queryParam = [];
        $search = $request['search'];


        if($request->has('search')) {
            $key = explode(' ', $request['search']);
            $shopkeepers->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('company', 'like', "%{$value}%");
                }
            });

            $queryParam = ['search' => $request['search']];
        }

        $shopkeepers =  $shopkeepers->get();

        return view('admin.shopkeeper.shopkeeper_list',compact('shopkeepers','queryParam'));
    }
    public function AppointmentList()
    {
        $appointments = Appointment::with('service','customer')->get()->all();
        return view('admin.appointment',compact('appointments'));
    }
    public function PaymentList()
    {
        $payments = Payment::with('customer','appointment')->get();
        return view('admin.payment',compact('payments'));
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
    public function ServiceProvider(Request $request)
    {
        $serviceProviders = ServiceProvider::with('user');
        $queryParam = [];
        $search = $request['search'];


        if($request->has('search')) {
            $key = explode(' ', $request['search']);
            $serviceProviders->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhereHas('user', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }
        });
            $queryParam = ['search' => $request['search']];
        }
        $serviceProviders = $serviceProviders->get();
        return view('admin.shopkeeper.serviceprovider',compact('serviceProviders','queryParam'));
    }
    public function Service(Request $request)
    {
        $services = Service::with('user','serviceProvider')->get();
        return view('admin.shopkeeper.service',compact('services'));
    }

    public function CustomerUpdate(Request $request)
    {
        $id = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'id' => 'required',
        ]);

        $customer = Customer::findOrFail($request->id);
        $customer->update([
            'name' =>$request->name,
            'email' => $request->email,
        ]);
        return back();
    }
    public function shopkeeperUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'company' => 'required',
        ]);
        $shopkeeper = User::findOrFail($request->id);
        $shopkeeper->update([
            'name' => $request->name,
            'company' => $request->company
        ]);
        return back();
    }
}