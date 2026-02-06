<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AddressSeeder::class,
            PersonSeeder::class,
            ClientSeeder::class,
            // Add other seeders here as needed
        ]);

        User::factory()
        ->count(5)
        ->create();

/*         Client::factory()
        ->count(5)
        ->create(); */
    }
}
