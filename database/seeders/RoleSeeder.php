<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'user',
        ]);
        Role::create([
            'name' => 'admin',
        ]);
        Role::factory()->count(10)->create();
    }
}
