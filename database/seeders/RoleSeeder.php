<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Accountant
        \App\Models\User::firstOrCreate(
            ['email' => 'accountant@rosevilla.com'],
            [
                'name' => 'Accountant User',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'accountant',
                'email_verified_at' => now(),
            ]
        );

        // Create Staff
        \App\Models\User::firstOrCreate(
            ['email' => 'staff@rosevilla.com'],
            [
                'name' => 'Staff User',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'staff',
                'email_verified_at' => now(),
            ]
        );
        
        // Ensure Admin exists too just in case
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@rosevilla.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
