<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'admin@gmail.com',
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'role' => 'admin'
        ]);
    }
}
