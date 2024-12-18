<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Service::insert([
            [
                'user_id' => 1, // Replace with a valid shopkeeper user ID
                'service_provider_id' => 1, // Replace with a valid service provider ID
                'title' => 'Oil Change',
                'description' => 'Replace engine oil and filter to ensure smooth engine performance. Includes a check for oil leaks and top-up of essential fluids.',
                'price' => 55.00,
                'duration' => 1,
                'duration_type' => 'days',
                'notify_via_email' => 1,
                'notify_via_sms' => 1,
                'first_reminder_enabled' => 1,
                'first_reminder_duration' => 2,
                'first_reminder_duration_type' => 'hours',
                'first_reminder_message' => 'Your appointment is in 2 hours!',
                'second_reminder_enabled' => 1,
                'second_reminder_duration' => 1,
                'second_reminder_duration_type' => 'hours',
                'second_reminder_message' => 'Your appointment is 1 hour!',
                'followup_reminder_enabled' => 1,
                'followup_reminder_duration' => 1,
                'followup_reminder_duration_type' => 'hours',
                'followup_reminder_message' => 'You had an appointment with us',
                
            ],
            [
                'user_id' => 1, // Replace with a valid shopkeeper user ID
                'service_provider_id' => 1, // Replace with a valid service provider ID
                'title' => 'Oil Change Free',
                'description' => 'Replace engine oil and filter to ensure smooth engine performance. Includes a check for oil leaks and top-up of essential fluids.',
                'price' => 0.00,
                'duration' => 1,
                'duration_type' => 'days',
                'notify_via_email' => 1,
                'notify_via_sms' => 1,
                'first_reminder_enabled' => 1,
                'first_reminder_duration' => 2,
                'first_reminder_duration_type' => 'hours',
                'first_reminder_message' => 'Your appointment is in 2 hours!',
                'second_reminder_enabled' => 1,
                'second_reminder_duration' => 1,
                'second_reminder_duration_type' => 'hours',
                'second_reminder_message' => 'Your appointment is 1 hour!',
                'followup_reminder_enabled' => 1,
                'followup_reminder_duration' => 1,
                'followup_reminder_duration_type' => 'hours',
                'followup_reminder_message' => 'You had an appointment with us',
                
            ],
        ]);
    }
}
