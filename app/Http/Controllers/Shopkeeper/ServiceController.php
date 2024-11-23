<?php

namespace App\Http\Controllers\Shopkeeper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        
        $services = Auth::user()->services()->withCount('appointments')->get();
       
        return view('shopkeeper.services.index', compact('services'));
    }

    
    public function create()
    {
       
        return view('shopkeeper.services.create');
        
    }
    
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000|regex:/^(\S+\s*){1,2000}$/', 
            'price' => 'required|numeric|min:0.01', 
            'duration' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        
        $reminders = ['first', 'second', 'followup'];
    
        
        foreach ($reminders as $reminder) {                                                                                                                                                                                                                                                 
            if ($request->boolean("{$reminder}_reminder_enabled")) {
                $validatedData["{$reminder}_reminder_enabled"] = true;
                $request->validate([
                    "{$reminder}_reminder_date" => [
                        'required', 
                        'date', 
                        ($reminder === 'first') 
                            ? 'after_or_equal:' . now()->toDateString() 
                            : "after:{$this->getPreviousReminderDate($reminders, $reminder)}",
                    ],
                    "{$reminder}_reminder_message" => 'required|string|max:1000',
                ]);
                $validatedData["{$reminder}_reminder_date"] = $request->input("{$reminder}_reminder_date");
                $validatedData["{$reminder}_reminder_message"] = $request->input("{$reminder}_reminder_message");
            } else {
                $validatedData["{$reminder}_reminder_enabled"] = false;
                $validatedData["{$reminder}_reminder_date"] = null;
                $validatedData["{$reminder}_reminder_message"] = null;
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
    
            $destinationPath = public_path('assets/uploads/services/');
            $file->move($destinationPath, $filename);

            $validatedData['image'] = $filename;
        }
    
        $validatedData['user_id'] = auth()->id();
        $service = Service::create($validatedData);
        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }


   
    /**
     * Get the previous reminder's date field for validation.
     *
     * @param array $reminders
     * @param string $currentReminder
     * @return string|null
     */
    private function getPreviousReminderDate(array $reminders, string $currentReminder): ?string
    {
        $currentIndex = array_search($currentReminder, $reminders);
        if ($currentIndex > 0) {
            $previousReminder = $reminders[$currentIndex - 1];
            return "{$previousReminder}_reminder_date";
        }
        return null;
    }
    
    public function edit(Service $service)
    {
        
        return view('shopkeeper.services.edit', compact('service'));
    }
  
public function update(Request $request, $id)
{
  
    $service = Service::findOrFail($id);

 
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:2000|regex:/^(\S+\s*){1,2000}$/', 
        'price' => 'required|numeric|min:0.01', 
        'duration' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
    ]);

    $reminders = ['first', 'second', 'followup'];

    foreach ($reminders as $reminder) {
        if ($request->boolean("{$reminder}_reminder_enabled")) {
            $validatedData["{$reminder}_reminder_enabled"] = true;
            $request->validate([
                "{$reminder}_reminder_date" => [
                    'required', 
                    'date', 
                    ($reminder === 'first') 
                        ? 'after_or_equal:' . now()->toDateString() 
                        : "after:{$this->getPreviousReminderDate($reminders, $reminder)}",
                ],
                "{$reminder}_reminder_message" => 'required|string|max:1000',
            ]);
            $validatedData["{$reminder}_reminder_date"] = $request->input("{$reminder}_reminder_date");
            $validatedData["{$reminder}_reminder_message"] = $request->input("{$reminder}_reminder_message");
        } else {
            $validatedData["{$reminder}_reminder_enabled"] = false;
            $validatedData["{$reminder}_reminder_date"] = null;
            $validatedData["{$reminder}_reminder_message"] = null;
        }
    }
    
    if ($request->hasFile('image')) {
        $uploadPath = 'assets/uploads/services/';
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path($uploadPath), $filename);
    
        if ($service->image) {
            $oldFilePath = public_path($uploadPath . $service->image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath); 
            }
        }
    
        $validatedData['image'] = $filename;
    }
   
    $service->update($validatedData);
   
    return redirect()->route('services.index')->with('success', 'Service updated successfully.');
}


    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}