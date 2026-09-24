<?php

namespace Tests\Feature;

use App\Filament\Widgets\PeminjamLocationMapWidget;
use App\Models\BastPemakaianDetail;
use App\Models\BastPemakaianHeader;
use App\Models\Item;
use App\Models\RefPejabat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeminjamLocationMapTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $staff;
    protected RefPejabat $pejabat;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->staff = User::factory()->staff()->create();

        $this->pejabat = RefPejabat::create([
            'nip' => '198501012010011001',
            'nama' => 'Pejabat Penyerah BMN',
            'jabatan' => 'Koordinator Sekretariat',
            'status' => 'aktif',
        ]);
    }

    public function test_bast_pemakaian_saves_location_and_address_data(): void
    {
        $header = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_NON_KIB',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'eksternal',
            'pihak_kedua_nama_manual' => 'Budi Santoso (Mitra Kerja)',
            'alamat_peminjam' => 'Jl. Sudirman No. 45, Bandar Lampung',
            'latitude' => -5.42971234,
            'longitude' => 105.26123456,
            'tanggal_bast' => now(),
            'status_dokumen' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        $this->assertDatabaseHas('bast_pemakaian_headers', [
            'id' => $header->id,
            'alamat_peminjam' => 'Jl. Sudirman No. 45, Bandar Lampung',
        ]);

        $this->assertTrue($header->hasLokasi());
        $this->assertEquals('Budi Santoso (Mitra Kerja)', $header->nama_peminjam);
        $this->assertEquals(-5.42971234, (float) $header->latitude);
        $this->assertEquals(105.26123456, (float) $header->longitude);

        // View page displays the location section and OpenStreetMap link
        $response = $this->actingAs($this->admin)->get(
            route('filament.admin.resources.bast-pemakaian-headers.view', $header)
        );
        $response->assertStatus(200);
        $response->assertSee('Lokasi Peminjam');
        $response->assertSee('Jl. Sudirman No. 45, Bandar Lampung');
        $response->assertSee('openstreetmap.org');
    }

    public function test_has_lokasi_returns_false_when_coordinates_are_missing(): void
    {
        $header = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_NON_KIB',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'eksternal',
            'pihak_kedua_nama_manual' => 'Budi Santoso',
            'alamat_peminjam' => 'Jl. Sudirman',
            'latitude' => null,
            'longitude' => null,
            'tanggal_bast' => now(),
            'status_dokumen' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        $this->assertFalse($header->hasLokasi());
    }

    public function test_peminjam_location_map_widget_access_control(): void
    {
        // Admin can view widget
        $this->actingAs($this->admin);
        $this->assertTrue(PeminjamLocationMapWidget::canView());

        // Staff cannot view widget (data pribadi)
        $this->actingAs($this->staff);
        $this->assertFalse(PeminjamLocationMapWidget::canView());
    }

    public function test_admin_dashboard_renders_map_widget(): void
    {
        $this->actingAs($this->admin);

        \Livewire\Livewire::test(PeminjamLocationMapWidget::class)
            ->assertSee('Peta Lokasi Peminjam Barang')
            ->assertSee('peminjam-map');
    }

    public function test_peminjam_location_map_widget_returns_correct_location_data(): void
    {
        $this->actingAs($this->admin);

        $item1 = Item::factory()->create([
            'kode_bmn' => 'BMN-LAPTOP-001',
            'nama_barang' => 'Laptop ASUS ROG',
            'status' => 'dipinjam',
        ]);

        $item2 = Item::factory()->create([
            'kode_bmn' => 'BMN-PROJ-002',
            'nama_barang' => 'Proyektor Epson',
            'status' => 'tersedia',
        ]);

        // BAST 1: Belum dikembalikan (masih dipinjam / dipakai)
        $bastDipinjam = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_NON_KIB',
            'nomor_bast' => 'BAST/2026/001',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'eksternal',
            'pihak_kedua_nama_manual' => 'Peminjam Aktif',
            'alamat_peminjam' => 'Jl. Kartini No. 10, Bandar Lampung',
            'latitude' => -5.40112233,
            'longitude' => 105.25334455,
            'tanggal_bast' => now(),
            'status_dokumen' => 'final',
            'created_by' => $this->admin->id,
        ]);

        BastPemakaianDetail::create([
            'bast_header_id' => $bastDipinjam->id,
            'item_id' => $item1->id,
            'kondisi_saat_diserahkan' => 'baik',
            'status_item' => 'dipakai',
        ]);

        // BAST 2: Sudah dikembalikan
        $bastDikembalikan = BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_NON_KIB',
            'nomor_bast' => 'BAST/2026/002',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'eksternal',
            'pihak_kedua_nama_manual' => 'Peminjam Selesai',
            'alamat_peminjam' => 'Jl. Raden Intan No. 20, Bandar Lampung',
            'latitude' => -5.41223344,
            'longitude' => 105.26445566,
            'tanggal_bast' => now()->subDays(5),
            'status_dokumen' => 'final',
            'created_by' => $this->admin->id,
        ]);

        BastPemakaianDetail::create([
            'bast_header_id' => $bastDikembalikan->id,
            'item_id' => $item2->id,
            'kondisi_saat_diserahkan' => 'baik',
            'status_item' => 'dikembalikan',
        ]);

        // BAST 3: Tanpa lokasi (harus di-exclude dari widget)
        BastPemakaianHeader::create([
            'jenis_bast' => 'BAST_PEMAKAIAN_NON_KIB',
            'nomor_bast' => 'BAST/2026/003',
            'pihak_pertama_nip' => $this->pejabat->nip,
            'pihak_kedua_tipe' => 'eksternal',
            'pihak_kedua_nama_manual' => 'Peminjam Tanpa Peta',
            'alamat_peminjam' => null,
            'latitude' => null,
            'longitude' => null,
            'tanggal_bast' => now(),
            'status_dokumen' => 'final',
            'created_by' => $this->admin->id,
        ]);

        $widget = new PeminjamLocationMapWidget();
        $locations = $widget->getLocations();

        $this->assertCount(2, $locations);

        $locDipinjam = collect($locations)->firstWhere('popup.nomor_bast', 'BAST/2026/001');
        $this->assertNotNull($locDipinjam);
        $this->assertEquals('dipinjam', $locDipinjam['status']);
        $this->assertEquals('Peminjam Aktif', $locDipinjam['popup']['nama']);
        $this->assertEquals('Jl. Kartini No. 10, Bandar Lampung', $locDipinjam['popup']['alamat']);
        $this->assertStringContainsString('Laptop ASUS ROG', $locDipinjam['popup']['barang']);

        $locDikembalikan = collect($locations)->firstWhere('popup.nomor_bast', 'BAST/2026/002');
        $this->assertNotNull($locDikembalikan);
        $this->assertEquals('dikembalikan', $locDikembalikan['status']);
        $this->assertEquals('Peminjam Selesai', $locDikembalikan['popup']['nama']);
    }
}
