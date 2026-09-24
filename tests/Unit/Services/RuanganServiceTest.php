<?php

namespace Tests\Unit\Services;

use App\Models\Item;
use App\Models\RefRuangan;
use App\Models\User;
use App\Services\RuanganService;
use Tests\TestCase;

class RuanganServiceTest extends TestCase
{
    private RuanganService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RuanganService;
    }

    public function test_mutasi_item_updates_item_location_and_creates_log(): void
    {
        $user = User::factory()->create();
        $asal = RefRuangan::factory()->create(['nama_ruangan' => 'Gudang Lama']);
        $tujuan = RefRuangan::factory()->create(['nama_ruangan' => 'Ruang Rapat Baru']);

        $item = Item::factory()->create([
            'ref_ruangan_id' => $asal->id,
            'lokasi_simpan' => 'Gudang Lama',
        ]);

        $mutation = $this->service->mutasiItem(
            item: $item,
            ruanganTujuan: $tujuan,
            alasan: 'Pemindahan unit projector untuk rapat koordinasi',
            userId: $user->id
        );

        $this->assertEquals($tujuan->id, $item->fresh()->ref_ruangan_id);
        $this->assertEquals('Ruang Rapat Baru', $item->fresh()->lokasi_simpan);

        $this->assertDatabaseHas('item_mutasi_ruangans', [
            'id' => $mutation->id,
            'item_id' => $item->id,
            'ruangan_asal_id' => $asal->id,
            'ruangan_tujuan_id' => $tujuan->id,
            'user_id' => $user->id,
            'alasan' => 'Pemindahan unit projector untuk rapat koordinasi',
        ]);
    }

    public function test_generate_dir_pdf_returns_pdf_instance_and_valid_filename(): void
    {
        $ruangan = RefRuangan::factory()->create(['kode_ruangan' => 'R-DIR-101']);
        Item::factory()->count(3)->create(['ref_ruangan_id' => $ruangan->id]);

        $result = $this->service->generateDirPdf($ruangan);

        $this->assertArrayHasKey('pdf', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertStringContainsString('DIR_R-DIR-101', $result['filename']);
        $this->assertStringEndsWith('.pdf', $result['filename']);
    }

    public function test_generate_room_qr_produces_svg_string(): void
    {
        $ruangan = RefRuangan::factory()->create(['kode_ruangan' => 'R-QR-202']);

        $svg = $this->service->generateRoomQr($ruangan);

        $this->assertIsString($svg);
        $this->assertStringContainsString('<svg', $svg);
    }
}
