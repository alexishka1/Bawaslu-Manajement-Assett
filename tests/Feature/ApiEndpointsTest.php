<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    public function test_api_login_with_valid_credentials_returns_token_data(): void
    {
        $user = User::factory()->staff()->create([
            'email' => 'api_staff@bawaslu.go.id',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'api_staff@bawaslu.go.id',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'user' => [
                        'email' => 'api_staff@bawaslu.go.id',
                        'role' => 'staff',
                    ],
                ],
            ]);
    }

    public function test_api_login_with_invalid_credentials_returns_401(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'wrong@bawaslu.go.id',
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'error' => 'INVALID_CREDENTIALS',
            ]);
    }

    public function test_api_items_listing_returns_paginated_data(): void
    {
        Item::factory()->count(5)->create(['status' => 'tersedia']);

        $response = $this->getJson('/api/v1/items');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
            ]);

        $this->assertEquals(5, $response->json('meta.total'));
    }

    public function test_api_scan_returns_correct_item_details(): void
    {
        $item = Item::factory()->create(['kode_bmn' => 'BMN-API-SCAN-01']);

        $response = $this->getJson('/api/v1/items/scan/BMN-API-SCAN-01');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'kode_bmn' => 'BMN-API-SCAN-01',
                ],
            ]);
    }

    public function test_api_scan_returns_404_when_item_not_found(): void
    {
        $response = $this->getJson('/api/v1/items/scan/BMN-NOT-FOUND-999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error' => 'ITEM_NOT_FOUND',
            ]);
    }

    public function test_api_reports_summary_returns_aggregated_statistics(): void
    {
        Item::factory()->count(4)->create(['status' => 'tersedia']);
        Item::factory()->count(2)->terpakai()->create();

        $response = $this->getJson('/api/v1/reports/summary');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'total_items' => 6,
                    'tersedia' => 4,
                    'terpakai' => 2,
                ],
            ]);
    }

    public function test_api_submit_report_stores_new_record(): void
    {
        Storage::fake('public');

        $user = User::factory()->staff()->create();
        $item = Item::factory()->create(['kode_bmn' => 'BMN-API-REP-01']);

        $file = UploadedFile::fake()->image('bukti_audit.jpg');

        $response = $this->actingAs($user)->postJson('/api/v1/reports', [
            'kode_bmn' => 'BMN-API-REP-01',
            'kondisi_aktual' => 'servis',
            'catatan' => 'Perlu pengecekan kabel daya.',
            'foto_bukti' => $file,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('item_reports', [
            'item_id' => $item->id,
            'kondisi_aktual' => 'servis',
            'status_validasi' => 'menunggu',
        ]);
    }
}
