<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Auth::user()->holidays; // Assuming `holidays` is a relation in User model
        return view('shopkeeper.holidays.index', compact('holidays'));
    }

    // Store a new holiday
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'is_full_day' => 'nullable|boolean',
            'description' => 'nullable|string|max:255',
        ]);
        if ($request->has('is_full_day')) {
            // Set start and end times to null if it's a full day
            $validated['start_time'] = null;
            $validated['end_time'] = null;
        }

        $validated['is_full_day'] = $request->has('is_full_day');
        $validated['user_id'] = Auth::id();

        Holiday::create($validated);

        return redirect()->back()->with('success', 'Holiday added successfully!');
    }

    // Update an existing holiday
    public function update(Request $request, Holiday $holiday)
    {
        // $this->authorize('update', $holiday); // Optional: Ensure the holiday belongs to the shopkeeper

        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'is_full_day' => 'nullable|boolean',
            'description' => 'nullable|string|max:255',
        ]);
        if ($request->has('is_full_day')) {
            // Set start and end times to null if it's a full day
            $validated['start_time'] = null;
            $validated['end_time'] = null;
        }

        $validated['is_full_day'] = $request->has('is_full_day');

        $holiday->update($validated);

        return redirect()->back()->with('success', 'Holiday updated successfully!');
    }

    // Delete a holiday
    public function destroy(Holiday $holiday)
    {
        // $this->authorize('delete', $holiday); // Optional: Ensure the holiday belongs to the shopkeeper
        $holiday->delete();

        return redirect()->back()->with('success', 'Holiday deleted successfully!');
    }
}
