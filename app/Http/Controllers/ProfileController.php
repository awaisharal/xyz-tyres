<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\ShopSchedule;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        // return $request->user();
        // Fetch the existing shop schedule, or create a new instance if none exists
        $shopSchedule = ShopSchedule::where('user_id', auth()->user()->id)->first() ?? new ShopSchedule();

        return view('shopkeeper.profile.edit', [
            'user' => $request->user(),
            'shopSchedule' => $shopSchedule
        ]);
    }



    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }



    public function updateSchedule(Request $request)
    {
        $request->validate([
            'monday_enabled' => 'nullable|boolean',
            'monday_start_time' => 'nullable|required_if:monday_enabled,true',
            'monday_end_time' => 'nullable|required_if:monday_enabled,true|after:monday_start_time',

            'tuesday_enabled' => 'nullable|boolean',
            'tuesday_start_time' => 'nullable|required_if:tuesday_enabled,true|',
            'tuesday_end_time' => 'nullable|required_if:tuesday_enabled,true|after:tuesday_start_time',

            'wednesday_enabled' => 'nullable|boolean',
            'wednesday_start_time' => 'nullable|required_if:wednesday_enabled,true',
            'wednesday_end_time' => 'nullable|required_if:wednesday_enabled,true|after:wednesday_start_time',

            'thursday_enabled' => 'nullable|boolean',
            'thursday_start_time' => 'nullable|required_if:thursday_enabled,true',
            'thursday_end_time' => 'nullable|required_if:thursday_enabled,true|after:thursday_start_time',

            'friday_enabled' => 'nullable|boolean',
            'friday_start_time' => 'nullable|required_if:friday_enabled,true',
            'friday_end_time' => 'nullable|required_if:friday_enabled,true|after:friday_start_time',

            'saturday_enabled' => 'nullable|boolean',
            'saturday_start_time' => 'nullable|required_if:saturday_enabled,true',
            'saturday_end_time' => 'nullable|required_if:saturday_enabled,true|after:saturday_start_time',

            'sunday_enabled' => 'nullable|boolean',
            'sunday_start_time' => 'nullable|required_if:sunday_enabled,true',
            'sunday_end_time' => 'nullable|required_if:sunday_enabled,true|after:sunday_start_time',
        ]);

        $user = Auth::user();

        // Fetch or create the schedule for the logged-in user
        $schedule = ShopSchedule::firstOrNew(['user_id' => $user->id]);

        // Update schedule data for each day
        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
            $schedule->{$day.'_enabled'} = $request->has($day.'_enabled');
            $schedule->{$day.'_start_time'} = $request->input($day.'_start_time', null);
            $schedule->{$day.'_end_time'} = $request->input($day.'_end_time', null);
        }

        // Save the schedule
        $schedule->save();

        return back()->with('status', 'schedule-updated');
    }

    public function getSchedule($userId)
    {
        $schedule = ShopSchedule::where('user_id', $userId)->first();
        return response()->json($schedule);
    }


}
