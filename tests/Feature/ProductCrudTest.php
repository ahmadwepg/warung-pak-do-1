<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_menu_lists_only_active_products(): void
    {
        $category = Category::create(['name' => 'Sembako']);
        $active = Product::create([
            'name' => 'Beras Pak Do',
            'category_id' => $category->id,
            'price' => 15000,
            'stock' => 20,
            'is_active' => true,
        ]);
        Product::create([
            'name' => 'Produk Nonaktif',
            'category_id' => $category->id,
            'price' => 10000,
            'stock' => 10,
            'is_active' => false,
        ]);

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee($active->name)
            ->assertDontSee('Produk Nonaktif');
    }
}
