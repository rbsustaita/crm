<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // You can create users here using User factory or manually
        // Example:
        // User::factory()->count(10)->create();

        // This Creates a specific user
        User::factory()->create([
            'name' => 'Administrador', // Replace with desired name
            'email' => 'admin@example.com', // Replace with desired email
            'role' => 'admin', // Replace with desired role
            'password' => bcrypt('password'), // Use bcrypt for password hashing
        ]);

    }
}
