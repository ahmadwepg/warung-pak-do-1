<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Nasi Goreng', 'sort_order' => 1],
            ['name' => 'Mie/Kwetiau/Bihun', 'sort_order' => 2],
            ['name' => 'Menu Ayam', 'sort_order' => 3],
            ['name' => 'Capcay/Paklay', 'sort_order' => 4],
            ['name' => 'Lain-lain', 'sort_order' => 5],
            ['name' => 'Minuman', 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category + ['description' => null]
            );
        }
    }
}
