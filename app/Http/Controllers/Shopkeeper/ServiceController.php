<?php

namespace App\Http\Controllers\Shopkeeper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        
        $services = Auth::user()->services; // Assuming the relationship is defined in the User model
        // return response()->json($services);
        return view('shopkeeper.services.index', compact('services'));
    }

    
    public function create()
    {
        // Return a view for creating a service (if applicable)
        return view('shopkeeper.services.create');
        
    }


    public function store(Request $request)
    {
        // Check if the authenticated user is a shopkeeper
        if (Auth::user()->role !== 'shopkeeper') {
            return response()->json(['message' => 'Unauthorized. Only shopkeepers can create services.'], 403);
        }
    
        // Validate the request
        $request->validate([
           
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'first_reminder_datetime' => 'nullable|date',
            'first_reminder_message' => 'nullable|string',
            'second_reminder_datetime' => 'nullable|date',
            'second_reminder_message' => 'nullable|string',
            'followup_reminder_datetime' => 'nullable|date',
            'followup_reminder_message' => 'nullable|string',
        ]);
        $imagePath = $request->file('image')->store('services', 'public');
    
        
        $service = Service::create([
            'user_id' => auth()->id(), // Get the authenticated user's ID
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'price' => $request->price,
            'duration' => $request->duration,
            'first_reminder_date' => $request->first_reminder_date,
            'first_reminder_message' => $request->first_reminder_message,
            'second_reminder_date' => $request->second_reminder_date,
            'second_reminder_message' => $request->second_reminder_message,
            'followup_reminder_date' => $request->followup_reminder_date,
            'followup_reminder_message' => $request->followup_reminder_message,
        ]);
    
        return redirect()->route('services.index')->with('success', 'Service created successfully.');
        // return response()->json(['message' => 'Service created successfully', 'service' => $service], 201);
    }

   
    public function edit(Service $service)
    {
        
        return view('shopkeeper.services.edit', compact('service'));
    }

    
    public function update(Request $request, Service $service)
{
    // Check if the authenticated user is a shopkeeper
    if (Auth::user()->role !== 'shopkeeper') {
       
        return response()->json(['message' => 'Unauthorized. Only shopkeepers can update services.'], 403);
    }

  
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|string', // Assuming this is a URL or path to the image
        'price' => 'required|numeric',
        'duration' => 'required|integer', // Duration in minutes or any unit you prefer
        'first_reminder_date' => 'nullable|date',
        'first_reminder_message' => 'nullable|string',
        'second_reminder_date' => 'nullable|date',
        'second_reminder_message' => 'nullable|string',
        'followup_reminder_date' => 'nullable|date',
        'followup_reminder_message' => 'nullable|string',
    ]);

    
    $service->update([
        'title' => $request->title,
        'description' => $request->description,
        'image' => $request->hasFile('image') ? $request->file('image')->store('services', 'public') : $service->image,
        'price' => $request->price,
        'duration' => $request->duration,
        'first_reminder_date' => $request->first_reminder_date,
        'first_reminder_message' => $request->first_reminder_message,
        'second_reminder_date' => $request->second_reminder_date,
        'second_reminder_message' => $request->second_reminder_message,
        'followup_reminder_date' => $request->followup_reminder_date,
        'followup_reminder_message' => $request->followup_reminder_message,
    ]);
    return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    // return response()->json(['message' => 'Service updated successfully', 'service' => $service], 200);
}

    
    public function destroy(Service $service)
    {
        
        if (Auth::user()->role !== 'shopkeeper') {
            return response()->json(['message' => 'Unauthorized. Only shopkeepers can delete services.'], 403);
        }
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
        // return response()->json(['message' => 'Service deleted successfully'], 200);
    }
}