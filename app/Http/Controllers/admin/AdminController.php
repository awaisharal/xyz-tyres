<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }
    public function login_post(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {

            Toastr::success('Welcome Back!');
            return redirect()->route('admin.dashboard');
        }
        
        return back()->withErrors(['email' => 'Invalid Credentials.']);
    }
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.dashboard',compact('admin'));
    }
    public function customers(Request $request)
    {
        $query = Customer::query();

        if ($request->has('search') && $request->search) {
            $key = explode(' ', $request->search);
            $query->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                      ->orWhere('email', 'like', "%{$value}%");
                }
            });
        }
    
        $customers = $query->paginate(10)->appends(['search' => $request->search]);
    
        return view('admin.customer.list', compact('customers'));
    }

    public function customer_update(Request $request)
    {
        $id = $request->validate([
            'name' => 'required',
            'id' => 'required',
        ]);

        $customer = Customer::findOrFail($request->id);
        $customer->update([
            'name' =>$request->name,
        ]);

        Toastr::success('Updated successfully');
        return back();
    }

    public function customer_delete(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        $customer->delete();
        Toastr::success('Deleted successfully');
        return back();
    }

    public function appointments(Request $request)
    {
        $query = Appointment::with('service', 'customer');
    
        if ($request->has('search') && $request->search) {
            $key = explode(' ', $request->search);
            $query->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhereHas('customer', function ($customerQuery) use ($value) {
                        $customerQuery->where('name', 'like', "%{$value}%")
                                      ->orWhere('email', 'like', "%{$value}%");
                    })
                    ->orWhereHas('service', function ($serviceQuery) use ($value) {
                        $serviceQuery->where('title', 'like', "%{$value}%");
                    })
                    ->orWhere('phone', 'like', "%{$value}%")
                    ->orWhere('date', 'like', "%{$value}%");
                }
            });
        }
    
        $appointments = $query->paginate(10)->appends(['search' => $request->search]);
        return view('admin.appointments.list', compact('appointments'));
    }

    public function appointments_delete(Request $request)
    {
        $appointments = Appointment::findorFail($request->id);
        $appointments->delete();

        Toastr::success('Deleted successfully');
        return back();
    }

    public function payments(Request $request)
    {
        $query = Payment::with('customer');

        if ($request->has('search') && $request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($customerQuery) use ($search) {
                    $customerQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('transaction_id', 'like', "%{$search}%")
                ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        $payments = $query->paginate(10)->appends(['search' => $request->search]);
        return view('admin.payments.list', compact('payments'));
    }

    public function shopkeepers(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search) {
            $key = explode(' ', $request->search);
            $query->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                      ->orWhere('email', 'like', "%{$value}%")
                      ->orWhere('company', 'like', "%{$value}%");
                }
            });
        }
    
        $shopkeepers = $query->paginate(10)->appends(['search' => $request->search]);
    
        return view('admin.shopkeeper.list', compact('shopkeepers'));
    }

    public function shopkeeper_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'company' => 'required'
        ]);

        $shopkeeper = User::findOrFail($request->id);
        $shopkeeper->update([
            'name' => $request->name,
            'company' => $request->company
        ]);

        Toastr::success('Updated successfully');
        return back();
    }
    
    public function shopkeeper_delete(Request $request)
    {
        $shopkeeper = User::findorFail($request->id);
        $shopkeeper->delete();
        Toastr::success('Deleted successfully');
        return back();
    }

    //toggle permission
    public function togglePermission(Request $request)
    {
        $shopkeeper = User::find($request->shopkeeper_id);

        if (!$shopkeeper) {
            return response()->json(['success' => false, 'message' => 'Shopkeeper not found']);
        }

        // Update the 'is_permitted' field
        $shopkeeper->is_permitted = $request->is_permitted;
        $shopkeeper->save();

        return response()->json(['success' => true]);
    }



    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        Toastr::success('Logout Successfully!');
        return redirect('admin/login');
    }
}