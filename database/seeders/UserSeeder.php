<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trainee;
use App\Models\Supervisor;
use App\Models\HR;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create 1 HR Account
        HR::create([
            'name' => 'Admin Test HR',
            'email' => 'hr@test.com',
            'password' => Hash::make('password123'),
            'employee_id' => 'HR001',
        ]);

        // Create 1 Supervisor Account
        Supervisor::create([
            'name' => 'Admin Test Supervisor',
            'email' => 'sv@test.com',
            'password' => Hash::make('password123'),
            'department' => 'IT Department',
            'position' => 'Senior Lead',
        ]);

        // Create 1 Trainee Account
        Trainee::create([
            'name' => 'Admin Test Trainee',
            'email' => 'trainee@test.com',
            'password' => Hash::make('password123'),
            'start_date' => '2024-01-01',
            'end_date' => '2024-06-01',
        ]);
    }
}