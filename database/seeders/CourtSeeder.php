<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\Sport;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sport = Sport::find(1);
        $sport2 = Sport::find(2);
        Court::create(['name' => 'Court A', 'sport_id' => $sport->id]);
        Court::create(['name' => 'Court B', 'sport_id' => $sport->id]);
        Court::create(['name' => 'Court C', 'sport_id' => $sport2->id]);
        Court::create(['name' => 'Court D', 'sport_id' => $sport->id]);
        Court::create(['name' => 'Court E', 'sport_id' => $sport2->id]);
    }
}
