<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\RefRuangan;
use App\Models\User;
use Tests\TestCase;

class RoomTrackingTest extends TestCase
{
    public function test_guest_is_redirected_to_login_when_accessing_room_scan(): void
    {
        $ruangan = RefRuangan::factory()->create(['kode_ruangan' => 'R-PUBLIC-01']);

        $response = $this->get('/scan/ruangan/'.$ruangan->kode_ruangan);
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_room_inventory_scanner(): void
    {
        $user = User::factory()->staff()->create();
        $ruangan = RefRuangan::factory()->create([
            'kode_ruangan' => 'R-COMM-101',
            'nama_ruangan' => 'Ruang Sentra Gakkumdu',
            'penanggung_jawab' => 'Komisioner Penindakan',
        ]);

        $item = Item::factory()->create([
            'kode_bmn' => 'BMN-GAKKUM-001',
            'nama_barang' => 'PC All-in-One Gakkumdu',
            'ref_ruangan_id' => $ruangan->id,
        ]);

        $response = $this->actingAs($user)->get('/scan/ruangan/'.$ruangan->kode_ruangan);

        $response->assertStatus(200);
        $response->assertSee('Ruang Sentra Gakkumdu');
        $response->assertSee('R-COMM-101');
        $response->assertSee('Komisioner Penindakan');
        $response->assertSee('BMN-GAKKUM-001');
        $response->assertSee('PC All-in-One Gakkumdu');
    }

    public function test_scan_room_returns_404_for_non_existent_room_code(): void
    {
        $user = User::factory()->staff()->create();

        $response = $this->actingAs($user)->get('/scan/ruangan/NON-EXISTENT-CODE');
        $response->assertStatus(404);
    }

    public function test_authenticated_user_can_relocate_item_into_scanned_room(): void
    {
        $user = User::factory()->staff()->create();
        $ruanganAsal = RefRuangan::factory()->create(['nama_ruangan' => 'Gudang Logistik']);
        $ruanganTujuan = RefRuangan::factory()->create([
            'kode_ruangan' => 'R-TARGET-202',
            'nama_ruangan' => 'Ruang Humas & Media Center',
        ]);

        $item = Item::factory()->create([
            'kode_bmn' => 'BMN-CAM-99',
            'nama_barang' => 'Sony Mirrorless A7 IV',
            'ref_ruangan_id' => $ruanganAsal->id,
            'lokasi_simpan' => 'Gudang Logistik',
        ]);

        $response = $this->actingAs($user)->post('/scan/ruangan/'.$ruanganTujuan->kode_ruangan, [
            'kode_bmn' => 'BMN-CAM-99',
            'alasan' => 'Ditempatkan di Media Center untuk peliputan konferensi pers pemilu',
        ]);

        $response->assertRedirect('/scan/ruangan/'.$ruanganTujuan->kode_ruangan);
        $response->assertSessionHas('success');

        $this->assertEquals($ruanganTujuan->id, $item->fresh()->ref_ruangan_id);
        $this->assertEquals('Ruang Humas & Media Center', $item->fresh()->lokasi_simpan);

        $this->assertDatabaseHas('item_mutasi_ruangans', [
            'item_id' => $item->id,
            'ruangan_asal_id' => $ruanganAsal->id,
            'ruangan_tujuan_id' => $ruanganTujuan->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_relocate_fails_when_item_not_found(): void
    {
        $user = User::factory()->staff()->create();
        $ruangan = RefRuangan::factory()->create(['kode_ruangan' => 'R-FAIL-TEST']);

        $response = $this->actingAs($user)->post('/scan/ruangan/'.$ruangan->kode_ruangan, [
            'kode_bmn' => 'BMN-TIDAK-ADA-12345',
            'alasan' => 'Test barang fiktif',
        ]);

        $response->assertRedirect('/scan/ruangan/'.$ruangan->kode_ruangan);
        $response->assertSessionHas('error');
    }

    public function test_authenticated_user_can_download_dir_pdf(): void
    {
        $user = User::factory()->staff()->create();
        $ruangan = RefRuangan::factory()->create(['kode_ruangan' => 'R-DIR-TEST']);
        Item::factory()->count(2)->create(['ref_ruangan_id' => $ruangan->id]);

        $response = $this->actingAs($user)->get('/ruangan/'.$ruangan->id.'/dir');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_authenticated_user_can_download_room_qr_svg(): void
    {
        $user = User::factory()->staff()->create();
        $ruangan = RefRuangan::factory()->create(['kode_ruangan' => 'R-QR-TEST']);

        $response = $this->actingAs($user)->get('/ruangan/'.$ruangan->id.'/qr');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'image/svg+xml');
        $this->assertStringContainsString('<svg', $response->getContent());
    }
}
