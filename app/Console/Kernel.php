<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        
        $schedule->call(function () {
            $appointments = \App\Models\Appointment::with(['service', 'customer'])
                ->whereHas('service', function ($query) {
                    $query->where('first_reminder_enabled', 1)
                        ->whereRaw('TIMESTAMPDIFF(HOUR, NOW(), CONCAT(appointments.date, " ", appointments.time)) = services.first_reminder_hours');
                })
                ->get();
                
        
            foreach ($appointments as $appointment) {
                // Notify the customer
                if ($appointment->customer) {
                    $appointment->customer->notify(new \App\Notifications\FirstReminderNotification($appointment, 'Test Reminder Message'));
                } else {
                    \Log::error('Customer not found for appointment ID: ' . $appointment->id);
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
