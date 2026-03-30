<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ecom.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_blocked' => false,
        ]);

        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Electronic devices and accessories', 'status' => true],
            ['name' => 'Clothing', 'slug' => 'clothing', 'description' => 'Fashion and apparel', 'status' => true],
            ['name' => 'Books', 'slug' => 'books', 'description' => 'Books and literature', 'status' => true],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'description' => 'Home improvement and gardening', 'status' => true],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sports equipment and gear', 'status' => true],
            ['name' => 'Beauty', 'slug' => 'beauty', 'description' => 'Beauty and personal care', 'status' => true],
            ['name' => 'Toys', 'slug' => 'toys', 'description' => 'Toys and games', 'status' => true],
            ['name' => 'Food', 'slug' => 'food', 'description' => 'Food and beverages', 'status' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
