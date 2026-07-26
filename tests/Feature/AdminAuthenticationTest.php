<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_the_public_menu(): void
    {
        $this->get(route('products.index'))->assertOk();
    }

    public function test_admin_can_log_in_and_access_product_management(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('rahasia-admin'),
            'role' => 'admin',
        ]);

        $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'rahasia-admin',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_non_admin_cannot_access_admin_area(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }
}
