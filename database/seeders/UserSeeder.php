<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Guesser\Name;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name'=>'shop',
                'email'=>'shop@gmail.com',
                'company'=>'Shop',
                'password'=>'password',
                'company_slug'=>'shop',
                'is_permitted'=>1
            ]

        ]);
    }
}
