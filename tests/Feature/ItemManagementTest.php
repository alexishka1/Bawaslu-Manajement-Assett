<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class ItemManagementTest extends TestCase
{
    public function test_item_creation_auto_generates_qr_url(): void
    {
        $item = Item::create([
            'kode_bmn' => 'BMN-TEST-SYNC-01',
            'nama_barang' => 'Scanner Dokumen Pemilu',
            'kategori' => 'Elektronik',
            'lokasi_simpan' => 'Ruang Arsip',
            'status' => 'tersedia',
        ]);

        $this->assertNotNull($item->qr_code);
        $this->assertStringContainsString('/scan/BMN-TEST-SYNC-01', $item->qr_code);
    }

    public function test_updating_kode_bmn_syncs_qr_code(): void
    {
        $item = Item::create([
            'kode_bmn' => 'BMN-OLD-CODE',
            'nama_barang' => 'Printer HP LaserJet',
            'kategori' => 'Elektronik',
            'lokasi_simpan' => 'Ruang Sekretariat',
            'status' => 'tersedia',
        ]);

        $this->assertStringContainsString('BMN-OLD-CODE', $item->qr_code);

        // Update kode BMN
        $item->update(['kode_bmn' => 'BMN-NEW-CODE-99']);

        $this->assertStringContainsString('BMN-NEW-CODE-99', $item->fresh()->qr_code);
    }

    public function test_admin_can_download_qr_code_svg(): void
    {
        $admin = User::factory()->admin()->create();
        $item = Item::factory()->create(['kode_bmn' => 'BMN-QR-DOWNLOAD']);

        $response = $this->actingAs($admin)->get(route('qrcode.download', $item));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'image/svg+xml');
        $this->assertStringContainsString('<svg', $response->getContent());
        $this->assertStringContainsString('BMN-QR-DOWNLOAD', $response->headers->get('content-disposition'));
    }

    public function test_staff_cannot_download_qr_code_svg(): void
    {
        $staff = User::factory()->staff()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($staff)->get(route('qrcode.download', $item));
        $response->assertRedirect(route('scan.index'));
        $response->assertSessionHas('warning');
    }

    public function test_guest_is_redirected_to_login_when_downloading_qr(): void
    {
        $item = Item::factory()->create();

        $response = $this->get(route('qrcode.download', $item));
        $response->assertRedirect('/login');
    }
}
