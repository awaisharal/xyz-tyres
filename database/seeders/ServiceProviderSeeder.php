<?php

namespace Database\Seeders;

use App\Models\ServiceProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ServiceProvider::insert([
            [
                'user_id' => 1,
                'name' => 'salik',
                'email' => 'salik@gmail.com',
                'phone' => '03113111133',
                'address' => 'home',

            ]
        ]);
    }
}