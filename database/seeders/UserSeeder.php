<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'Admin User', 'email' => 'admin1@example.com', 'password' => Hash::make('password123')]);
        User::create(['name' => 'John Doe', 'email' => 'john2@example.com', 'password' => Hash::make('password123')]);
        User::create(['name' => 'Jane Smith', 'email' => 'jane3@example.com', 'password' => Hash::make('password123')]);
        User::create(['name' => 'Emma Johnson', 'email' => 'emma4@example.com', 'password' => Hash::make('password123')]);
        User::create(['name' => 'Luke Brown', 'email' => 'luke5@example.com', 'password' => Hash::make('password123')]);

    }
}
