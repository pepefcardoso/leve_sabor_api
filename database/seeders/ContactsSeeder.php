<?php

namespace Database\Seeders;

use App\Models\Contacts;
use App\Models\Phone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contacts::factory(10)
            ->has(Phone::factory()->count(2))
            ->create();
    }
}
