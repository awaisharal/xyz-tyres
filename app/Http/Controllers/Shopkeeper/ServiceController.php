<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\User;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use LaravelQRCode\Facades\QRCode;


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
        $service = new Service();
        $user = auth()->user();
        $templates = Template::where('user_id', Auth::id())->get();
        $serviceProviders = ServiceProvider::where('user_id', Auth::id())->get();
        // return $templates;
        return view('shopkeeper.services.create', compact('serviceProviders', 'templates', 'service'));
    }

    //templates 
    public function getTemplateMessage(Request $request)
    {
        $key = $request->query('key'); // Get the key from the request
        $user = auth()->user(); // Get the logged-in user

        // Find the template message for the given key
        $template = Template::where('user_id', Auth::id())->where('key', $key)->first();

        if ($template) {
            return response()->json([
                'success' => true,
                'message' => $template->value,
            ]);
        }

        return response()->json(['success' => false], 404);
    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'service_provider_id' => 'required|exists:service_providers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'duration' => 'required|numeric|min:1',
            'duration_type' => 'required',
            'notify_via_email' => 'nullable|boolean',
            'notify_via_sms' => 'nullable|boolean',
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
            'duration_type' => $request->duration_type,
            'notify_via_email' => $request->has('notify_via_email') ? 1 : 0,
            'notify_via_sms' => $request->has('notify_via_sms') ? 1 : 0,
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
        Toastr::success('Service added successfully');
        return redirect()->route('services.index');
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
            'price' => 'required|numeric',
            'duration' => 'required|numeric|min:1',
            'duration_type' => 'required',
            'notify_via_email' => 'nullable|boolean',
            'notify_via_sms' => 'nullable|boolean',
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
            'duration_type' => $request->duration_type, // Time value (HH:MM)
            'notify_via_email' => $request->has('notify_via_email') ? 1 : 0,
            'notify_via_sms' => $request->has('notify_via_sms') ? 1 : 0,
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
        Toastr::success('Service updated successfully');
        return redirect()->route('services.index');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        // Delete the associated image if exists
        if ($service->image) {
            Storage::delete('public/' . $service->image);
        }

        $service->delete();
        Toastr::success('Service deleted successfully');
        return redirect()->route('services.index');
    }

    public function generateQrCode(Request $request)
    {
        $serviceUrl = $request->input('serviceUrl');

        $path = public_path('/qr-code.png');
        QRCode::text($serviceUrl)
            ->setSize(5)
            ->setOutfile($path) 
            ->png(); 

        $qrCodeData = file_get_contents($path); 
        $base64QrCode = base64_encode($qrCodeData); 

        return response()->json([
            'qrCodeData' => 'data:image/png;base64,' . $base64QrCode,
        ]);
    }
}
