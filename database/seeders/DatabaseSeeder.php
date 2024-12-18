<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            ServiceProviderSeeder::class,
            ServiceSeeder::class,
            CustomerSeeder::class,
            AppointmentSeeder::class,
            PaymentSeeder::class,
            TemplateSeeder::class
        ]);
    }
}
