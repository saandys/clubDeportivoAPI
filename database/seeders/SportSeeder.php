<?php

namespace Database\Seeders;

use App\Models\Sport;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sport::create(['name' => 'Fútbol']);
        Sport::create(['name' => 'Tenis']);
        Sport::create(['name' => 'Paddle']);
        Sport::create(['name' => 'Baloncesto']);
        Sport::create(['name' => 'Natación']);
    }
}
