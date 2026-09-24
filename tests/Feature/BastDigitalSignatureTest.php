<?php

namespace Tests\Feature;

use App\Models\BastPemakaianDetail;
use App\Models\BastPemakaianHeader;
use App\Models\BastPengembalianDetail;
use App\Models\BastPengembalianHeader;
use App\Models\ConfigPenomoran;
use App\Models\Item;
use App\Models\RefPegawai;
use App\Models\RefPejabat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BastDigitalSignatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $staff;

    protected RefPejabat $pejabat;

    protected RefPegawai $pegawai;

    protected Item $item;

    // 1x1 transparent PNG as base64 data URI
    protected string $sampleSignature = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->admin = User::factory()->create([
            'email' => 'admin@bawaslu.go.id',
            'role' => 'admin',
        ]);

        $this->staff = User::factory()->create([
            'email' => 'staff@bawaslu.go.id',
            'role' => 'staff',
        ]);

        $this->pejabat = RefPejabat::create([
            'nip' => '197501012000031001',
            'nama' => 'Drs. H. Pejabat Bawaslu, M.Si',
            'jabatan' => 'Pejabat Pembuat Komitmen',
            'unit_kerja' => 'Sekretariat Bawaslu',
            'status' => 'aktif',
        ]);

        $this->pegawai = RefPegawai::create([
            'nip' => '199002022015031002',
            'nama' => 'Ahmad Staff, S.Kom',
            'jabatan' => 'Pranata Komputer',
            'unit_kerja' => 'Subbag Pengawasan',
            'status' => 'aktif',
        ]);

        $this->item = Item::factory()->create([
            'kode_bmn' => 'BMN-SIGN-001',
            'nama_barang' => 'Laptop Lenovo ThinkPad T14',
            'kategori' => 'Elektronik',
            'status' => 'tersedia',
        ]);

        ConfigPenomoran::create([
            'jenis_dokumen' => 'BAST_PEMAKAIAN_NON_KIB',
            'format_nomor' => '{nomor}/BAST-BMN/{bulan_romawi}/{tahun}',
            'counter_terakhir' => 0,
            'tahun_berjalan' => 2026,
        ]);

        ConfigPenomoran::create([
            'jenis_dokumen' => 'BAST_PENGEMBALIAN',
            'format_nomor' => '{nomor}/BAST-KEMBALI/{bulan_romawi}/{tahun}',
            'counter_terakhir' => 0,
            'tahun_berjalan' => 2026,
        ]);
    }

    public function test_can_view_bast_pemakaian_sign_interface(): void
    {
        $header = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_NON_KIB',
            'tanggal_bast' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'internal',
            'pihak_kedua_nip' => $this->pegawai->nip,
            'status_dokumen' => 'draft',
            'dibuat_oleh' => $this->admin->id,
        ]);

        BastPemakaianDetail::create([
            'bast_header_id' => $header->id,
            'item_id' => $this->item->id,
            'status_item' => 'dipakai',
        ]);

        // Pihak 1 signing interface
        $response1 = $this->get(route('bast.pemakaian.sign', [$header, 'pihak1']));
        $response1->assertOk()
            ->assertSee('Tanda Tangan Digital BAST')
            ->assertSee($this->pejabat->nama);

        // Pihak 2 signing interface
        $response2 = $this->get(route('bast.pemakaian.sign', [$header, 'pihak2']));
        $response2->assertOk()
            ->assertSee('Tanda Tangan Digital BAST')
            ->assertSee($this->pegawai->nama);
    }

    public function test_can_submit_signature_and_auto_finalize_when_both_signed(): void
    {
        $header = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_NON_KIB',
            'tanggal_bast' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'internal',
            'pihak_kedua_nip' => $this->pegawai->nip,
            'status_dokumen' => 'draft',
            'dibuat_oleh' => $this->admin->id,
        ]);

        BastPemakaianDetail::create([
            'bast_header_id' => $header->id,
            'item_id' => $this->item->id,
            'status_item' => 'dipakai',
        ]);

        // Step 1: Sign Pihak 1
        $responsePihak1 = $this->post(route('bast.pemakaian.sign.store', [$header, 'pihak1']), [
            'signature' => $this->sampleSignature,
        ]);

        $responsePihak1->assertRedirect();
        $header->refresh();
        $this->assertNotNull($header->ttd_pihak1_url);
        $this->assertEquals('draft', $header->status_dokumen);

        // Verify file stored in public disk
        $path = str_replace('/storage/', '', $header->ttd_pihak1_url);
        Storage::disk('public')->assertExists($path);

        // Step 2: Sign Pihak 2
        $responsePihak2 = $this->post(route('bast.pemakaian.sign.store', [$header, 'pihak2']), [
            'signature' => $this->sampleSignature,
        ]);

        $responsePihak2->assertRedirect();
        $header->refresh();
        $this->assertNotNull($header->ttd_pihak2_url);

        // Since both have signed, status becomes final and official number is generated!
        $this->assertEquals('final', $header->status_dokumen);
        $this->assertNotNull($header->nomor_bast);
        $this->assertStringContainsString('BAST-BMN', $header->nomor_bast);
    }

    public function test_public_verification_page_for_bast_pemakaian(): void
    {
        $header = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_NON_KIB',
            'tanggal_bast' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'internal',
            'pihak_kedua_nip' => $this->pegawai->nip,
            'ttd_pihak1_url' => '/storage/signatures/sample1.png',
            'ttd_pihak2_url' => '/storage/signatures/sample2.png',
            'status_dokumen' => 'final',
            'dibuat_oleh' => $this->admin->id,
        ]);

        BastPemakaianDetail::create([
            'bast_header_id' => $header->id,
            'item_id' => $this->item->id,
            'status_item' => 'dipakai',
        ]);

        $response = $this->get(route('bast.pemakaian.verify', $header));
        $response->assertOk()
            ->assertSee('Dokumen Sah')
            ->assertSee($header->nomor_bast)
            ->assertSee($this->pejabat->nama)
            ->assertSee($this->pegawai->nama)
            ->assertSee($this->item->kode_bmn);
    }

    public function test_bast_pengembalian_signature_and_verification_flow(): void
    {
        $kembali = BastPengembalianHeader::create([
            'tanggal' => now(),
            'lokasi' => 'Ruang BMN Bawaslu',
            'pihak_menyerahkan_tipe' => 'internal',
            'pihak_menyerahkan_nip' => $this->pegawai->nip,
            'pihak_menerima_nip' => $this->pejabat->nip,
            'status_dokumen' => 'draft',
            'dibuat_oleh' => $this->admin->id,
        ]);

        BastPengembalianDetail::create([
            'pengembalian_header_id' => $kembali->id,
            'item_id' => $this->item->id,
            'kondisi_saat_kembali' => 'Baik',
        ]);

        // Access sign page
        $this->get(route('bast.pengembalian.sign', [$kembali, 'pihak1']))
            ->assertOk()
            ->assertSee('Tanda Tangan Digital BAST');

        // Submit signature Pihak 1 (Pengembali)
        $this->post(route('bast.pengembalian.sign.store', [$kembali, 'pihak1']), [
            'signature' => $this->sampleSignature,
        ])->assertRedirect();

        $kembali->refresh();
        $this->assertNotNull($kembali->ttd_pihak1_url);

        // Submit signature Pihak 2 (Pejabat BMN)
        $this->post(route('bast.pengembalian.sign.store', [$kembali, 'pihak2']), [
            'signature' => $this->sampleSignature,
        ])->assertRedirect();

        $kembali->refresh();
        $this->assertNotNull($kembali->ttd_pihak2_url);
        $this->assertEquals('final', $kembali->status_dokumen);
        $this->assertNotNull($kembali->nomor_bast_pengembalian);

        // Public verification page
        $this->get(route('bast.pengembalian.verify', $kembali))
            ->assertOk()
            ->assertSee('Dokumen Pengembalian Sah')
            ->assertSee($kembali->nomor_bast_pengembalian);
    }

    public function test_download_pdf_contains_digital_signature_and_qr_verification(): void
    {
        $header = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_NON_KIB',
            'tanggal_bast' => now(),
            'lokasi' => 'Kantor Bawaslu',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'internal',
            'pihak_kedua_nip' => $this->pegawai->nip,
            'ttd_pihak1_url' => $this->sampleSignature,
            'ttd_pihak2_url' => $this->sampleSignature,
            'status_dokumen' => 'final',
            'dibuat_oleh' => $this->admin->id,
        ]);

        BastPemakaianDetail::create([
            'bast_header_id' => $header->id,
            'item_id' => $this->item->id,
            'status_item' => 'dipakai',
        ]);

        $response = $this->actingAs($this->admin)->get(route('bast.pemakaian.download', $header));
        $response->assertOk();
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));
    }
}
