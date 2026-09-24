<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\RefRuangan;
use App\Models\User;
use Tests\TestCase;

class FilamentResourcesTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_access_items_index_and_create_page(): void
    {
        $ruangan = RefRuangan::factory()->create();
        Item::factory()->count(3)->create(['ref_ruangan_id' => $ruangan->id]);

        $responseIndex = $this->actingAs($this->admin)->get('/admin/items');
        $responseIndex->assertStatus(200);

        $responseCreate = $this->actingAs($this->admin)->get('/admin/items/create');
        $responseCreate->assertStatus(200);
    }

    public function test_admin_can_access_all_filament_resources_index_pages(): void
    {
        $urls = [
            '/admin/users',
            '/admin/ref-ruangans',
            '/admin/ref-pegawais',
            '/admin/ref-pejabats',
            '/admin/item-transactions',
            '/admin/item-reports',
            '/admin/bast-pemakaian-headers',
            '/admin/bast-pengembalian-headers',
            '/admin/config-penomorans',
            '/admin/config-templates',
        ];

        foreach ($urls as $url) {
            $response = $this->actingAs($this->admin)->get($url);
            $response->assertStatus(200);
        }
    }

    public function test_admin_can_access_bast_create_pages(): void
    {
        $this->actingAs($this->admin)->get('/admin/bast-pemakaian-headers/create')->assertStatus(200);
        $this->actingAs($this->admin)->get('/admin/bast-pengembalian-headers/create')->assertStatus(200);
    }
}
