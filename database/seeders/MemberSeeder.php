<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::create(['name' => 'John Doe', 'email' => 'john1@example.com', 'phone' => '1234567890']);
        Member::create(['name' => 'Jane Smith', 'email' => 'jane2@example.com', 'phone' => '0987654321']);
        Member::create(['name' => 'Mark Spencer', 'email' => 'mark3@example.com', 'phone' => '4561237890']);
        Member::create(['name' => 'Emma Johnson', 'email' => 'emma4@example.com', 'phone' => '7894561230']);
        Member::create(['name' => 'Luke Brown', 'email' => 'luke5@example.com', 'phone' => '3216549870']);

    }
}
