<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // go to userseeder.php and run HR, SV, and Trainee accounts.
        $this->call([
            UserSeeder::class,
        ]);

    }
}