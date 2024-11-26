<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    // Display the list of service providers for the authenticated shopkeeper
    public function index()
    {
        // Fetch service providers associated with the logged-in shopkeeper (user_id)
        $serviceProviders = ServiceProvider::where('user_id', auth()->id())->get();
        return view('shopkeeper.serviceproviders.index', compact('serviceProviders'));
    }

    // Show the form for creating a new service provider
    public function create()
    {
        return view('shopkeeper.serviceproviders.create');
    }

    // Store a newly created service provider in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:service_providers,email',
            'phone' => 'required|string|max:15|unique:service_providers,phone',
            'address' => 'nullable|string|max:500',
        ]);

        // Create the service provider and associate it with the logged-in shopkeeper
        ServiceProvider::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => auth()->id(), // Associate with the logged-in user's ID
        ]);

        return redirect()->route('service-providers.index')->with('success', 'Service provider added successfully.');
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
        // Ensure the service provider belongs to the logged-in shopkeeper
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

        return redirect()->route('service-providers.index')->with('success', 'Service provider updated successfully.');
    }

    // Remove the specified service provider from the database
    public function destroy(ServiceProvider $serviceProvider)
    {
        // Ensure the service provider belongs to the logged-in shopkeeper
        if ($serviceProvider->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $serviceProvider->delete();

        return redirect()->route('service-providers.index')->with('success', 'Service provider deleted successfully.');
    }
}
