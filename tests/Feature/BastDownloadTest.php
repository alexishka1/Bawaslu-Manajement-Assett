<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\ItemTransaction;
use App\Models\User;
use Tests\TestCase;

class BastDownloadTest extends TestCase
{
    public function test_guest_cannot_download_bast_or_qrcode(): void
    {
        $item = Item::factory()->create();
        $transaction = ItemTransaction::factory()->create(['item_id' => $item->id]);

        $this->get("/bast/{$transaction->id}/download")->assertRedirect('/login');
        $this->get("/qrcode/{$item->id}/download")->assertRedirect('/login');
    }

    public function test_staff_cannot_download_bast_or_qrcode_and_receives_forbidden(): void
    {
        $staff = User::factory()->staff()->create();
        $item = Item::factory()->create();
        $transaction = ItemTransaction::factory()->create(['item_id' => $item->id]);

        $this->actingAs($staff)
            ->get("/bast/{$transaction->id}/download")
            ->assertStatus(403);

        $this->actingAs($staff)
            ->get("/qrcode/{$item->id}/download")
            ->assertRedirect(route('scan.index'));
    }

    public function test_admin_can_download_qrcode(): void
    {
        $admin = User::factory()->admin()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($admin)->get("/qrcode/{$item->id}/download");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/svg+xml');
    }
}
