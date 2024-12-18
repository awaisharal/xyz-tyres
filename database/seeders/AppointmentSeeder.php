<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Appointment::insert([
            [
                'service_id' => 1,
                'customer_id' => 1,
                'date' => '2024-12-20',
                'time' => '10:00:00',
                'phone' => '030010100001',
                'payment_status' => 'PAID',
            ],
            [
                'service_id' => 2,
                'customer_id' => 1,
                'date' => '2024-12-21',
                'time' => '14:00:00',
                'phone' => '030010100001',
                'status' => 'scheduled',
            ],
        ]);
    }
}
