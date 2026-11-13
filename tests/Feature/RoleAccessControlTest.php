<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_housekeeper_and_tenant_can_only_view_the_inventory_overview(): void
    {
        Asset::create([
            'name' => 'Kulkas bersama',
            'category' => 'Elektronik',
            'location' => 'Dapur',
            'quantity' => 1,
            'asset_condition' => 'Baik',
            'status' => 'Digunakan',
            'price' => 1500000,
        ]);

        foreach ([User::ROLE_HOUSEKEEPER, User::ROLE_TENANT] as $role) {
            $user = User::factory()->create(['role' => $role]);

            $this->actingAs($user)
                ->get(route('assets.index'))
                ->assertOk()
                ->assertSee('Kulkas bersama')
                ->assertDontSee('Tambah aset')
                ->assertDontSee(route('assets.show', 1));

            $this->get(route('assets.create'))->assertForbidden();
            $this->get(route('assets.show', 1))->assertForbidden();
            $this->get(route('assets.edit', 1))->assertForbidden();
            $this->post(route('assets.store'), [
                'name' => 'Aset terlarang',
                'category' => 'Elektronik',
                'location' => 'Dapur',
                'quantity' => 1,
                'asset_condition' => 'Baik',
                'status' => 'Digunakan',
                'price' => 100000,
            ])->assertForbidden();
        }

        $this->assertDatabaseCount('assets', 1);
    }

    public function test_admin_can_access_asset_management_pages(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]))
            ->get(route('assets.create'))
            ->assertOk();
    }
}
