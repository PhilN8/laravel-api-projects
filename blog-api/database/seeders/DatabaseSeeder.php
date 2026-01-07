<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User as Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $authors = Author::factory(15)->create();
        $categories = Category::factory(10)->create();

        Post::factory()
            ->recycle($authors)
            ->recycle($categories)
            ->count(60)
            ->create();
    }
}
