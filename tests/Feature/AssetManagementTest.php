<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));
    }

    public function test_dashboard_shows_asset_summary_and_inventory(): void
    {
        Asset::create($this->assetData([
            'name' => 'Kulkas bersama',
            'quantity' => 2,
            'price' => 1500000,
        ]));

        $this->get('/')
            ->assertOk()
            ->assertSee('Manajemen aset')
            ->assertSee('Kulkas bersama')
            ->assertSee('2 <span>unit</span>', false)
            ->assertSee('Rp 3.000.000');
    }

    public function test_assets_can_be_created_viewed_updated_and_deleted(): void
    {
        $this->get(route('assets.create'))->assertOk();

        $this->post(route('assets.store'), $this->assetData())
            ->assertRedirect();

        $asset = Asset::query()->firstOrFail();
        $this->assertSame('AC kamar 1', $asset->name);

        $this->get(route('assets.show', $asset))
            ->assertOk()
            ->assertSee('AC kamar 1')
            ->assertSee('Kamar 1');

        $this->get(route('assets.edit', $asset))->assertOk();

        $this->put(route('assets.update', $asset), $this->assetData([
            'name' => 'AC kamar utama',
            'quantity' => 2,
        ]))->assertRedirect(route('assets.show', $asset));

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'name' => 'AC kamar utama',
            'quantity' => 2,
        ]);

        $this->delete(route('assets.destroy', $asset))
            ->assertRedirect(route('assets.index'));

        $this->assertDatabaseMissing('assets', ['id' => $asset->id]);
    }

    public function test_inventory_can_be_searched_and_filtered(): void
    {
        Asset::create($this->assetData(['name' => 'Kulkas pantry', 'location' => 'Dapur']));
        Asset::create($this->assetData([
            'name' => 'Kursi rusak',
            'category' => 'Furniture',
            'location' => 'Kamar 2',
            'asset_condition' => 'Rusak',
        ]));

        $this->get('/?search=pantry')
            ->assertOk()
            ->assertSee('Kulkas pantry')
            ->assertDontSee('Kursi rusak');

        $this->get('/?category=Furniture&condition=Rusak')
            ->assertOk()
            ->assertSee('Kursi rusak')
            ->assertDontSee('Kulkas pantry');
    }

    public function test_asset_input_is_validated(): void
    {
        $this->from(route('assets.create'))
            ->post(route('assets.store'), [
                'name' => '',
                'category' => 'Tidak dikenal',
                'quantity' => 0,
                'location' => '',
                'asset_condition' => 'Tidak dikenal',
                'status' => 'Tidak dikenal',
                'price' => -1,
            ])
            ->assertRedirect(route('assets.create'))
            ->assertSessionHasErrors(['name', 'category', 'quantity', 'location', 'asset_condition', 'status', 'price']);

        $this->assertDatabaseCount('assets', 0);
    }

    /**
     * @return array<string, mixed>
     */
    private function assetData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'AC kamar 1',
            'category' => 'Elektronik',
            'location' => 'Kamar 1',
            'quantity' => 1,
            'asset_condition' => 'Baik',
            'status' => 'Digunakan',
            'purchase_date' => '2025-01-15',
            'price' => 3500000,
            'notes' => 'AC inverter',
        ], $overrides);
    }
}
