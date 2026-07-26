<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_add_menu_to_cart_and_checkout(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $category = \App\Models\Category::create(['name' => 'Nasi Goreng']);
        $product = Product::create([
            'name' => 'Nasi Goreng Spesial', 'category_id' => $category->id, 'price' => 18000,
            'stock' => 20, 'is_active' => true,
        ]);

        $this->actingAs($user)
            ->post(route('cart.add', $product), ['quantity' => 2])
            ->assertRedirect(route('cart.index'));

        $this->post(route('checkout.process'), [
            'customer_name' => 'Budi', 'customer_phone' => '08123456789',
            'customer_address' => 'Jl. Mawar 10', 'delivery_method' => 'antar', 'payment_method' => 'cod',
        ])->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'phone' => '08123456789', 'total_price' => 41000, 'delivery_method' => 'antar',
        ]);

        $order = \App\Models\Order::first();
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);
    }
}
