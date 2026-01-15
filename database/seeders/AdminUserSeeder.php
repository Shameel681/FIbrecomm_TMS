<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
    \App\Models\User::create([
        'name' => 'System Admin',
        'email' => 'admin@fibrecomm.com',
        'password' => bcrypt('admin123'),
        'role' => 'admin',
    ]);
    }
}
