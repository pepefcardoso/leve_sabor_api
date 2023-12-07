<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Phone::factory()->count(10)->create();
    }
}
