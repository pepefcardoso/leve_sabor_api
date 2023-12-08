<?php

namespace Database\Seeders;

use App\Models\CookingStyle;
use Illuminate\Database\Seeder;

class CookingStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CookingStyle::factory(10)->create();
    }
}
