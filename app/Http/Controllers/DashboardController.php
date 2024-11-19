<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'super_admin') {
            return view('super_admin.dashboard');
        } elseif ($user->role === 'shopkeeper') {
            return redirect()->route('dashboard.shopkeeper');
        } else {
            return redirect()->route('dashboard.customer');
        }
    }

    public function shopkeeper()
    {
        $services = Auth::user()->services;
        return view('shopkeeper.services.index',compact('services'));
    }

    public function customer()
    {
        return view('customer.dashboard');
    }
}
