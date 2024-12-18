<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Payment::insert([
            [
                'appointment_id' => 1,
                'customer_id'=> 1,
                'amount' => 50.00,
                'payment_status' => 'PAID',
                'transaction_id' => 'xcsdewt351354fcasa',
            ]
        ]);
    }
}
