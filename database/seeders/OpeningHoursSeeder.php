<?php

namespace Database\Seeders;

use App\Models\OpeningHours;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpeningHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OpeningHours::factory()->count(10)->create();
    }
}
