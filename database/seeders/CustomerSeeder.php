<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Customer::insert([
            [
                'name' => 'Customer',
                'email' => 'customer@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Awais',
                'email' => 'awais@example.com',
                'password' => bcrypt('password'),
            ],
        ]);
    }
}
