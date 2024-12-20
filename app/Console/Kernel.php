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
            // Fetch appointments for first reminder
            $firstReminderAppointments = \App\Models\Appointment::with(['service', 'customer'])
                ->whereHas('service', function ($query) {
                    $query->where('first_reminder_enabled', 1)
                        ->where(function ($subQuery) {
                            // Handle the case when first_reminder_duration_type is 'hours'
                            $subQuery->where('services.first_reminder_duration_type', 'hours')
                                ->whereRaw('TIMESTAMPDIFF(HOUR, NOW(), CONCAT(appointments.date, " ", appointments.time)) = services.first_reminder_duration');
                        })
                        ->orWhere(function ($subQuery) {
                            // Handle the case when first_reminder_duration_type is 'days'
                            $subQuery->where('services.first_reminder_duration_type', 'days')
                                ->whereRaw('TIMESTAMPDIFF(DAY, NOW(), CONCAT(appointments.date, " ", appointments.time)) = services.first_reminder_duration');
                        });
                })
                ->get();

            foreach ($firstReminderAppointments as $appointment) {
                $this->sendReminder($appointment, 'first');
            }

    
            // Fetch appointments for second reminder
            $secondReminderAppointments = \App\Models\Appointment::with(['service', 'customer'])
                ->whereHas('service', function ($query) {
                    $query->where('second_reminder_enabled', 1)
                        ->where(function ($subQuery) {
                            // Handle the case when second_reminder_duration_type is 'hours'
                            $subQuery->where('services.second_reminder_duration_type', 'hours')
                                ->whereRaw('TIMESTAMPDIFF(HOUR, NOW(), CONCAT(appointments.date, " ", appointments.time)) = services.second_reminder_duration');
                        })
                        ->orWhere(function ($subQuery) {
                            // Handle the case when second_reminder_duration_type is 'days'
                            $subQuery->where('services.second_reminder_duration_type', 'days')
                                ->whereRaw('TIMESTAMPDIFF(DAY, NOW(), CONCAT(appointments.date, " ", appointments.time)) = services.second_reminder_duration');
                        });
                })
                ->get();
    
            foreach ($secondReminderAppointments as $appointment) {
                $this->sendReminder($appointment, 'second');
            }
    
            // Fetch appointments for follow-up reminder
            $followupReminderAppointments = \App\Models\Appointment::with(['service', 'customer'])
                ->whereHas('service', function ($query) {
                    $query->where('followup_reminder_enabled', 1)
                        ->where(function ($subQuery) {
                            // Handle the case when followup_reminder_duration_type is 'hours'
                            $subQuery->where('services.followup_reminder_duration_type', 'hours')
                                ->whereRaw('TIMESTAMPDIFF(HOUR, CONCAT(appointments.date, " ", appointments.time), NOW()) = services.followup_reminder_duration');
                        })
                        ->orWhere(function ($subQuery) {
                            // Handle the case when followup_reminder_duration_type is 'days'
                            $subQuery->where('services.followup_reminder_duration_type', 'days')
                                ->whereRaw('TIMESTAMPDIFF(DAY, CONCAT(appointments.date, " ", appointments.time), NOW()) = services.followup_reminder_duration');
                        })
                        ->orWhere(function ($subQuery) {
                            // Handle the case when followup_reminder_duration_type is 'months'
                            $subQuery->where('services.followup_reminder_duration_type', 'months')
                                ->whereRaw('TIMESTAMPDIFF(MONTH, CONCAT(appointments.date, " ", appointments.time), NOW()) = services.followup_reminder_duration');
                        });
                })
                ->get();

            foreach ($followupReminderAppointments as $appointment) {
                $this->sendReminder($appointment, 'followup');
            }

        })->everyMinute(); // Adjust frequency as needed
    }
    
    // Handle sending reminders based on notification types
    public function sendReminder($appointment, $type)
    {
        $service = $appointment->service;

        // Check notification preferences for Email and SMS
        $emailNotification = $service->notify_via_email;
        $smsNotification = $service->notify_via_sms;

        // Send notifications based on the type
        if ($type === 'first' && $service->first_reminder_enabled) {
            $this->sendEmailNotification($appointment, \App\Notifications\FirstReminderNotification::class, 'This is your first reminder.');
            $this->sendSmsNotification($appointment, 'First Reminder');
        } elseif ($type === 'second' && $service->second_reminder_enabled) {
            $this->sendEmailNotification($appointment, \App\Notifications\SecondReminderNotification::class, 'This is your second reminder.');
            $this->sendSmsNotification($appointment, 'Second Reminder');
        } elseif ($type === 'followup' && $service->followup_reminder_enabled) {
            $this->sendEmailNotification($appointment, \App\Notifications\FollowupReminderNotification::class, 'Thank you for attending your appointment!');
            $this->sendSmsNotification($appointment, 'Follow-Up Reminder');
        }
    }

    // Send email notification
    public function sendEmailNotification($appointment, $notificationClass, $message)
    {
        if ($appointment->customer) {
            $appointment->customer->notify(new $notificationClass($appointment, $message));
        } else {
            \Log::error('Customer not found for appointment ID: ' . $appointment->id);
        }
    }

    // Send SMS notification (placeholder for now)
    public function sendSmsNotification($appointment, $type)
    {
        // Placeholder logic for SMS. Implement SMS API or logic as needed
        \Log::info("Sending $type SMS reminder for appointment ID: " . $appointment->id);
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