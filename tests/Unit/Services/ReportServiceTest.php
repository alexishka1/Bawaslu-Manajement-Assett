<?php

namespace Tests\Unit\Services;

use App\Models\Item;
use App\Models\ItemReport;
use App\Models\User;
use App\Services\ReportService;
use Tests\TestCase;

class ReportServiceTest extends TestCase
{
    private ReportService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ReportService;
    }

    public function test_get_asset_statistics_calculates_correct_counts(): void
    {
        $tersedia = Item::factory()->count(3)->create(['status' => 'tersedia']);
        Item::factory()->count(2)->terpakai()->create();
        Item::factory()->count(1)->rusak()->create();

        ItemReport::factory()->count(2)->create([
            'item_id' => $tersedia->first()->id,
            'status_validasi' => 'menunggu',
        ]);

        $stats = $this->service->getAssetStatistics();

        $this->assertEquals(6, $stats['total_items']);
        $this->assertEquals(3, $stats['tersedia']);
        $this->assertEquals(2, $stats['terpakai']);
        $this->assertEquals(1, $stats['rusak']);
        $this->assertEquals(2, $stats['laporan_menunggu']);
    }

    public function test_submit_report_persists_new_report(): void
    {
        $item = Item::factory()->create();
        $user = User::factory()->staff()->create();

        $report = $this->service->submitReport(
            item: $item,
            userId: $user->id,
            kondisiAktual: 'servis',
            catatan: 'Perlu servis rutin berkala.',
            fotoBuktiPath: 'reports/servis.jpg'
        );

        $this->assertDatabaseHas('item_reports', [
            'id' => $report->id,
            'item_id' => $item->id,
            'user_id' => $user->id,
            'kondisi_aktual' => 'servis',
            'status_validasi' => 'menunggu',
        ]);
    }
}
