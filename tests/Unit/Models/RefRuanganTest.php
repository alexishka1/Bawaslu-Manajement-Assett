<?php

namespace Tests\Unit\Models;

use App\Models\Item;
use App\Models\ItemMutasiRuangan;
use App\Models\RefRuangan;
use App\Models\User;
use Tests\TestCase;

class RefRuanganTest extends TestCase
{
    public function test_ruangan_can_be_created_with_factory(): void
    {
        $ruangan = RefRuangan::factory()->create([
            'kode_ruangan' => 'R-TEST-99',
            'nama_ruangan' => 'Ruang Rapat Pleno',
        ]);

        $this->assertDatabaseHas('ref_ruangans', [
            'kode_ruangan' => 'R-TEST-99',
            'nama_ruangan' => 'Ruang Rapat Pleno',
        ]);
        $this->assertNotNull($ruangan->qr_url);
        $this->assertStringContainsString('R-TEST-99', $ruangan->qr_url);
    }

    public function test_ruangan_has_many_items(): void
    {
        $ruangan = RefRuangan::factory()->create();
        $item = Item::factory()->create([
            'ref_ruangan_id' => $ruangan->id,
        ]);

        $this->assertTrue($ruangan->items->contains($item));
        $this->assertInstanceOf(Item::class, $ruangan->items->first());
        $this->assertEquals($ruangan->id, $item->ruangan->id);
    }

    public function test_ruangan_tracks_mutasi_masuk_and_keluar(): void
    {
        $user = User::factory()->create();
        $ruanganAsal = RefRuangan::factory()->create(['nama_ruangan' => 'Gudang Aset']);
        $ruanganTujuan = RefRuangan::factory()->create(['nama_ruangan' => 'Ruang Ketua']);
        $item = Item::factory()->create(['ref_ruangan_id' => $ruanganTujuan->id]);

        $mutasi = ItemMutasiRuangan::create([
            'item_id' => $item->id,
            'ruangan_asal_id' => $ruanganAsal->id,
            'ruangan_tujuan_id' => $ruanganTujuan->id,
            'user_id' => $user->id,
            'alasan' => 'Permintaan penambahan monitor kerja komisioner',
            'tanggal_mutasi' => now()->toDateString(),
        ]);

        $this->assertTrue($ruanganAsal->mutasiKeluar->contains($mutasi));
        $this->assertTrue($ruanganTujuan->mutasiMasuk->contains($mutasi));
        $this->assertTrue($item->mutasiRuangans->contains($mutasi));
    }
}
