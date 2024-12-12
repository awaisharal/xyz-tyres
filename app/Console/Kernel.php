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
                // Get the service associated with the appointment
                $service = $appointment->service;

                // Check if the service has reminder notifications enabled for email or SMS
                $emailNotification = $service->notify_via_email;
                $smsNotification = $service->notify_via_sms;

                // Send notifications based on settings
                $this->sendReminder($service, $emailNotification, $smsNotification, $appointment);
            }
        })->everyMinute();
    }

// Handle sending reminders based on notification types
    public function sendReminder($service, $emailNotification, $smsNotification, $appointment)
    {
        if ($emailNotification && $smsNotification) {
            // Send both email and SMS
            $this->sendEmailNotification($service, $appointment);
            $this->sendSmsNotification($service, $appointment);
        } elseif ($emailNotification) {
            // Send only email
            $this->sendEmailNotification($service, $appointment);
        } elseif ($smsNotification) {
            // Send only SMS
            $this->sendSmsNotification($service, $appointment);
        }
    }

// Send email notification
    public function sendEmailNotification($service, $appointment)
    {
        if ($appointment->customer) {
            $appointment->customer->notify(new \App\Notifications\FirstReminderNotification($appointment, 'Test Reminder Message'));
        } else {
            \Log::error('Customer not found for appointment ID: ' . $appointment->id);
        }
    }

    // Send SMS notification (placeholder for now)
    public function sendSmsNotification($service, $appointment)
    {
        // Placeholder logic for SMS. Implement SMS API or logic as needed
        \Log::info('Sending SMS reminder for appointment ID: ' . $appointment->id);
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
