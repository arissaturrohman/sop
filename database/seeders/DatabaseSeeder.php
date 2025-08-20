<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administator',
            'email' => 'admin@gmail.com',
            'role' => 'admin', // Set role to admin for testing
             'password' => Hash::make('123')
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'role' => 'user', // Set role to user for testing
            'password' => Hash::make('123')
        ]);
    }
}
