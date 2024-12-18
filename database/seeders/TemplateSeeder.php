<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Template::insert([
            [
                'user_id' => 1, // Replace with a valid user ID
                'key' => 'First Reminder',
                'value' => 'This is your First reminder, you hae an appointment with us after 2 hours.',               
            ],
            [
                'user_id' => 1,
                'key' => 'Second Reminder',
                'value' => 'This is your Second reminder, you hae an appointment with us after 1 hour.',               
            ],
            [
                'user_id' => 1,
                'key' => 'Followup Reminder',
                'value' => 'This is your Follow-up reminder, you had an appointment with us.',               
            ]            
        ]);
    }
}
