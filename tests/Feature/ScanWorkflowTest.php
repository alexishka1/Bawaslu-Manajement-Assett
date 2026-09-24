<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ScanWorkflowTest extends TestCase
{
    public function test_guest_is_redirected_to_login_when_accessing_scan(): void
    {
        $response = $this->get('/scan');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_scanner_and_item_detail(): void
    {
        $user = User::factory()->staff()->create();
        $item = Item::factory()->create(['kode_bmn' => 'BMN-SCAN-001']);

        $response = $this->actingAs($user)->get('/scan');
        $response->assertStatus(200);

        $responseDetail = $this->actingAs($user)->get('/scan/BMN-SCAN-001');
        $responseDetail->assertStatus(200);
        $responseDetail->assertSee('BMN-SCAN-001');
    }

    public function test_authenticated_user_can_submit_item_report_with_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->staff()->create();
        $item = Item::factory()->create(['kode_bmn' => 'BMN-SCAN-002']);

        $file = UploadedFile::fake()->image('laporan_rusak.jpg');

        $response = $this->actingAs($user)->post('/scan/BMN-SCAN-002', [
            'kondisi_aktual' => 'rusak',
            'catatan' => 'Layar monitor pecah saat dipindahkan.',
            'foto_bukti' => $file,
        ]);

        $response->assertRedirect('/scan/BMN-SCAN-002');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('item_reports', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'kondisi_aktual' => 'rusak',
            'status_validasi' => 'menunggu',
            'catatan' => 'Layar monitor pecah saat dipindahkan.',
        ]);

        $this->assertNotEmpty(Storage::disk('public')->allFiles('reports'));
    }
}
