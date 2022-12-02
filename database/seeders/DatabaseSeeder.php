<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use PHPUnit\Util\Test;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->has(Category::factory()->count(3))
            ->create();

        Category::factory()
            ->has(Product::factory()->count(3))
            ->create();
    }
}
