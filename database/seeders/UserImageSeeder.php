<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\UserImage::factory()->count(10)->create();
    }
}
