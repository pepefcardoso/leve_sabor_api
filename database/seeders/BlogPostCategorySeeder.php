<?php

namespace Database\Seeders;

use App\Models\BlogPostCategory;
use Illuminate\Database\Seeder;

class BlogPostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogPostCategory::factory()->count(10)->create();
    }
}
