<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $services = Service::where('user_id', Auth::id())->get();
        return view('shopkeeper.services.index', compact('services'));
    }

    public function create()
    {
        
        $serviceProviders = ServiceProvider::where('user_id', Auth::id())->get();
        return view('shopkeeper.services.create', compact('serviceProviders'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'service_provider_id' => 'required|exists:service_providers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'duration' => 'nullable|date_format:H:i',
            'first_reminder_enabled' => 'boolean',
            'first_reminder_hours' => 'nullable|integer',
            'first_reminder_message' => 'nullable|string',
            'second_reminder_enabled' => 'boolean',
            'second_reminder_hours' => 'nullable|integer',
            'second_reminder_message' => 'nullable|string',
            'followup_reminder_enabled' => 'boolean',
            'followup_reminder_hours' => 'nullable|integer',
            'followup_reminder_message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload if present
        $imagePath = null;

if ($request->hasFile('image')) {
    $file = $request->file('image');
    
    // Use the original file name
    $originalName = $file->getClientOriginalName();
    
    // Optionally prepend a unique timestamp to avoid name collisions
    $filename =  $originalName;

    // Define the destination path
    $destinationPath = public_path('assets/uploads/services/');
    
    // Move the file to the destination path
    $file->move($destinationPath, $filename);

    // Store the original or modified name in the database
    $imagePath = $filename;
}


        // Create the service
        Service::create([
            'user_id' => auth()->id(), 
            'service_provider_id' => $request->service_provider_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'image' => $imagePath,
            'first_reminder_enabled' => $request->first_reminder_enabled ?? false,
            'first_reminder_hours' => $request->first_reminder_hours,
            'first_reminder_message' => $request->first_reminder_message,
            'second_reminder_enabled' => $request->second_reminder_enabled ?? false,
            'second_reminder_hours' => $request->second_reminder_hours,
            'second_reminder_message' => $request->second_reminder_message,
            'followup_reminder_enabled' => $request->followup_reminder_enabled ?? false,
            'followup_reminder_hours' => $request->followup_reminder_hours,
            'followup_reminder_message' => $request->followup_reminder_message,
        ]);

        return redirect()->route('services.index')->with('success', 'Service added successfully');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $serviceProviders = ServiceProvider::all();
        return view('shopkeeper.services.edit', compact('service', 'serviceProviders'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'service_provider_id' => 'required|exists:service_providers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'duration' => 'nullable|date_format:H:i',
            'first_reminder_enabled' => 'boolean',
            'first_reminder_hours' => 'nullable|integer',
            'first_reminder_message' => 'nullable|string',
            'second_reminder_enabled' => 'boolean',
            'second_reminder_hours' => 'nullable|integer',
            'second_reminder_message' => 'nullable|string',
            'followup_reminder_enabled' => 'boolean',
            'followup_reminder_hours' => 'nullable|integer',
            'followup_reminder_message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $service = Service::findOrFail($id);

        $imagePath = $service->image;
        if ($request->hasFile('image')) {
           
            if ($service->image) {
                $oldImagePath = public_path('assets/uploads/services/' . $service->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            
            $file = $request->file('image');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
    
            $destinationPath = public_path('assets/uploads/services/');
            $file->move($destinationPath, $filename);
    
            $imagePath = $filename;
        }


        // Update the service details
        $service->update([
            'service_provider_id' => $request->service_provider_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration, // Time value (HH:MM)
            'image' => $imagePath,
            'first_reminder_enabled' => $request->first_reminder_enabled ?? false,
            'first_reminder_hours' => $request->first_reminder_hours,
            'first_reminder_message' => $request->first_reminder_message,
            'second_reminder_enabled' => $request->second_reminder_enabled ?? false,
            'second_reminder_hours' => $request->second_reminder_hours,
            'second_reminder_message' => $request->second_reminder_message,
            'followup_reminder_enabled' => $request->followup_reminder_enabled ?? false,
            'followup_reminder_hours' => $request->followup_reminder_hours,
            'followup_reminder_message' => $request->followup_reminder_message,
        ]);

        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        // Delete the associated image if exists
        if ($service->image) {
            Storage::delete('public/' . $service->image);
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
}
