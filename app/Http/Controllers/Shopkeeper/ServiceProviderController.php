<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\Appointment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    
    public function index()
    {
       
        $serviceProviders = ServiceProvider::where('user_id', auth()->id())->get();
      
        return view('shopkeeper.serviceproviders.index', compact('serviceProviders'));
    }

   
    public function create()
    {
        return view('shopkeeper.serviceproviders.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:service_providers,email',
            'phone' => 'required|string|max:15|unique:service_providers,phone',
            'address' => 'nullable|string|max:500',
        ]);

       
        ServiceProvider::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => auth()->id(), 
        ]);
        Toastr::success('Service provider added successfully.');
        return redirect()->route('service-providers.index');
    }

    // Show the form for editing the specified service provider
    public function edit(ServiceProvider $serviceProvider)
    {
        // Ensure the service provider belongs to the logged-in shopkeeper
        if ($serviceProvider->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('shopkeeper.serviceproviders.edit', compact('serviceProvider'));
    }

    // Update the specified service provider in the database
    public function update(Request $request, ServiceProvider $serviceProvider)
    {
       
        if ($serviceProvider->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:service_providers,email,' . $serviceProvider->id,
            'phone' => 'required|string|max:15|unique:service_providers,phone,' . $serviceProvider->id,
            'address' => 'nullable|string|max:500',
        ]);

        $serviceProvider->update($request->only('name', 'email', 'phone', 'address'));
        Toastr::success('Service provider updated successfully.');
        return redirect()->route('service-providers.index');
    }

   
    public function destroy(ServiceProvider $serviceProvider)
    {       
        if ($serviceProvider->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $serviceProvider->delete();
        Toastr::success('Service provider deleted successfully.');
        return redirect()->route('service-providers.index');
    }
}
