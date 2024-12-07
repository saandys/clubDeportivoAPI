<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\Member;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = Member::take(5)->get();
        $courts = Court::take(2)->get();

        Reservation::create(['member_id' => $members[0]->id, 'court_id' => $courts[0]->id, 'date' => '2024-12-07', 'start_time' => '08:00:00', 'end_time' => '09:00:00']);
        Reservation::create(['member_id' => $members[1]->id, 'court_id' => $courts[1]->id, 'date' => '2024-12-07', 'start_time' => '09:00:00', 'end_time' => '10:00:00']);
        Reservation::create(['member_id' => $members[2]->id, 'court_id' => $courts[0]->id, 'date' => '2024-12-07', 'start_time' => '10:00:00', 'end_time' => '11:00:00']);
        Reservation::create(['member_id' => $members[3]->id, 'court_id' => $courts[1]->id, 'date' => '2024-12-07', 'start_time' => '11:00:00', 'end_time' => '12:00:00']);
        Reservation::create(['member_id' => $members[4]->id, 'court_id' => $courts[0]->id, 'date' => '2024-12-07', 'start_time' => '12:00:00', 'end_time' => '13:00:00']);

    }
}
