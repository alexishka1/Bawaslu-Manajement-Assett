<?php

namespace Tests\Feature;

use App\Models\BastPemakaianDetail;
use App\Models\BastPemakaianHeader;
use App\Models\BastPengembalianDetail;
use App\Models\BastPengembalianHeader;
use App\Models\Item;
use App\Models\RefPegawai;
use App\Models\RefPejabat;
use App\Models\User;
use Tests\TestCase;

class BastWorkflowTest extends TestCase
{
    private User $admin;

    private User $staff;

    private RefPejabat $pejabat;

    private RefPegawai $pegawai;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->staff = User::factory()->staff()->create();

        $this->pejabat = RefPejabat::create([
            'nip' => '197001011995031001',
            'nama' => 'Drs. H. Suryanto, M.Si',
            'jabatan' => 'Kepala Sekretariat Bawaslu',
            'status' => 'aktif',
        ]);

        $this->pegawai = RefPegawai::create([
            'nip' => '198802152010121002',
            'nama' => 'Ahmad Fauzi, S.Kom',
            'jabatan' => 'Staf IT',
            'unit_kerja' => 'Subbagian Data dan Informasi',
            'status' => 'aktif',
        ]);
    }

    public function test_admin_can_create_bast_pemakaian_in_draft_status(): void
    {
        $item1 = Item::factory()->create(['status' => 'tersedia']);
        $item2 = Item::factory()->create(['status' => 'tersedia']);

        $header = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_KIB',
            'status_dokumen' => 'draft',
            'tanggal_bast' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'internal',
            'pihak_kedua_nip' => $this->pegawai->nip,
            'dibuat_oleh' => $this->admin->id,
        ]);

        BastPemakaianDetail::create([
            'bast_header_id' => $header->id,
            'item_id' => $item1->id,
            'kondisi_saat_diserahkan' => 'Baik',
        ]);

        BastPemakaianDetail::create([
            'bast_header_id' => $header->id,
            'item_id' => $item2->id,
            'kondisi_saat_diserahkan' => 'Baik',
        ]);

        $this->assertDatabaseHas('bast_pemakaian_headers', [
            'id' => $header->id,
            'status_dokumen' => 'draft',
            'nomor_bast' => null,
        ]);

        // Status barang masih tersedia karena BAST masih draft
        $this->assertEquals('tersedia', $item1->fresh()->status);
        $this->assertEquals('tersedia', $item2->fresh()->status);
    }

    public function test_finalizing_bast_pemakaian_generates_official_number_and_locks_items(): void
    {
        $item = Item::factory()->create(['status' => 'tersedia']);

        $header = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_KIB',
            'status_dokumen' => 'draft',
            'tanggal_bast' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'internal',
            'pihak_kedua_nip' => $this->pegawai->nip,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $detail = BastPemakaianDetail::create([
            'bast_header_id' => $header->id,
            'item_id' => $item->id,
            'kondisi_saat_diserahkan' => 'Baik',
        ]);

        // Terbitkan BAST (final)
        $header->update(['status_dokumen' => 'final']);

        $headerFresh = $header->fresh();
        $this->assertEquals('final', $headerFresh->status_dokumen);
        $this->assertNotNull($headerFresh->nomor_bast);
        $this->assertStringContainsString('/BAST-KIB/', $headerFresh->nomor_bast);

        // Barang otomatis terkunci menjadi terpakai
        $this->assertEquals('terpakai', $item->fresh()->status);
    }

    public function test_admin_can_create_bast_pengembalian_and_restore_item_status(): void
    {
        $item = Item::factory()->create(['status' => 'tersedia']);

        $pemakaian = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_KIB',
            'status_dokumen' => 'final',
            'tanggal_bast' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'internal',
            'pihak_kedua_nip' => $this->pegawai->nip,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $pemakaianDetail = BastPemakaianDetail::create([
            'bast_header_id' => $pemakaian->id,
            'item_id' => $item->id,
            'kondisi_saat_diserahkan' => 'Baik',
        ]);

        $this->assertEquals('terpakai', $item->fresh()->status);

        // Buat BAST Pengembalian
        $pengembalian = BastPengembalianHeader::create([
            'tanggal' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_menyerahkan_tipe' => 'internal',
            'pihak_menyerahkan_nip' => $this->pegawai->nip,
            'pihak_menerima_nip' => $this->pejabat->nip,
            'status_dokumen' => 'final',
            'dibuat_oleh' => $this->admin->id,
        ]);

        BastPengembalianDetail::create([
            'pengembalian_header_id' => $pengembalian->id,
            'bast_pemakaian_detail_id' => $pemakaianDetail->id,
            'kondisi_saat_kembali' => 'Baik',
        ]);

        // Nomor BAST pengembalian resmi terbit
        $this->assertNotNull($pengembalian->fresh()->nomor_bast_pengembalian);
        $this->assertStringContainsString('/BAST-KEMBALI/', $pengembalian->fresh()->nomor_bast_pengembalian);

        // Status pemakaian detail jadi dikembalikan
        $this->assertEquals('dikembalikan', $pemakaianDetail->fresh()->status_item);

        // Status barang kembali menjadi tersedia
        $this->assertEquals('tersedia', $item->fresh()->status);
    }

    public function test_returning_item_with_damage_sets_status_to_rusak(): void
    {
        $item = Item::factory()->create(['status' => 'tersedia']);

        $pemakaian = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_NON_KIB',
            'status_dokumen' => 'final',
            'tanggal_bast' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'internal',
            'pihak_kedua_nip' => $this->pegawai->nip,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $pemakaianDetail = BastPemakaianDetail::create([
            'bast_header_id' => $pemakaian->id,
            'item_id' => $item->id,
            'kondisi_saat_diserahkan' => 'Baik',
        ]);

        $pengembalian = BastPengembalianHeader::create([
            'tanggal' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_menyerahkan_tipe' => 'internal',
            'pihak_menyerahkan_nip' => $this->pegawai->nip,
            'pihak_menerima_nip' => $this->pejabat->nip,
            'status_dokumen' => 'final',
            'dibuat_oleh' => $this->admin->id,
        ]);

        BastPengembalianDetail::create([
            'pengembalian_header_id' => $pengembalian->id,
            'bast_pemakaian_detail_id' => $pemakaianDetail->id,
            'kondisi_saat_kembali' => 'Rusak Berat',
            'catatan_kerusakan' => 'Motherboard terbakar',
        ]);

        // Karena rusak berat, status aset berubah menjadi rusak
        $this->assertEquals('rusak', $item->fresh()->status);
    }

    public function test_admin_can_download_bast_pemakaian_and_pengembalian_pdf(): void
    {
        $header = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_KIB',
            'status_dokumen' => 'final',
            'tanggal_bast' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'internal',
            'pihak_kedua_nip' => $this->pegawai->nip,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $responsePemakaian = $this->actingAs($this->admin)->get(route('bast.pemakaian.download', $header));
        $responsePemakaian->assertStatus(200);
        $responsePemakaian->assertHeader('content-type', 'application/pdf');

        $pengembalian = BastPengembalianHeader::create([
            'tanggal' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_menyerahkan_tipe' => 'internal',
            'pihak_menyerahkan_nip' => $this->pegawai->nip,
            'pihak_menerima_nip' => $this->pejabat->nip,
            'status_dokumen' => 'final',
            'dibuat_oleh' => $this->admin->id,
        ]);

        $responsePengembalian = $this->actingAs($this->admin)->get(route('bast.pengembalian.download', $pengembalian));
        $responsePengembalian->assertStatus(200);
        $responsePengembalian->assertHeader('content-type', 'application/pdf');
    }

    public function test_staff_cannot_download_bast_pemakaian_pdf(): void
    {
        $header = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_KIB',
            'status_dokumen' => 'final',
            'tanggal_bast' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'internal',
            'pihak_kedua_nip' => $this->pegawai->nip,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->staff)->get(route('bast.pemakaian.download', $header));
        $response->assertStatus(403);
    }
}
