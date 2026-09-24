<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\ItemReport;
use App\Models\User;
use Tests\TestCase;

class ReportValidationWorkflowTest extends TestCase
{
    public function test_admin_validating_report_updates_item_status(): void
    {
        $admin = User::factory()->admin()->create();
        $staff = User::factory()->staff()->create();
        $item = Item::factory()->create(['status' => 'tersedia']);

        $report = ItemReport::create([
            'item_id' => $item->id,
            'user_id' => $staff->id,
            'kondisi_aktual' => 'rusak',
            'catatan' => 'Layar proyektor mati total akibat konsleting.',
            'foto_bukti' => 'reports/test_rusak.jpg',
            'status_validasi' => 'menunggu',
        ]);

        $this->assertEquals('tersedia', $item->fresh()->status);
        $this->assertEquals('menunggu', $report->fresh()->status_validasi);

        // Simulasi aksi admin memvalidasi
        $report->update([
            'status_validasi' => 'divalidasi',
            'divalidasi_oleh' => $admin->id,
            'tanggal_validasi' => now(),
        ]);
        $report->item->update(['status' => $report->kondisi_aktual]);

        $this->assertEquals('divalidasi', $report->fresh()->status_validasi);
        $this->assertEquals($admin->id, $report->fresh()->divalidasi_oleh);
        $this->assertEquals($admin->name, $report->fresh()->validator->name);
        $this->assertEquals('rusak', $item->fresh()->status);
    }

    public function test_admin_rejecting_report_leaves_item_status_intact(): void
    {
        $admin = User::factory()->admin()->create();
        $staff = User::factory()->staff()->create();
        $item = Item::factory()->create(['status' => 'tersedia']);

        $report = ItemReport::create([
            'item_id' => $item->id,
            'user_id' => $staff->id,
            'kondisi_aktual' => 'hilang',
            'catatan' => 'Salah lapor, barang ternyata ada di ruangan lain.',
            'foto_bukti' => 'reports/test_hilang.jpg',
            'status_validasi' => 'menunggu',
        ]);

        // Simulasi aksi admin menolak
        $report->update([
            'status_validasi' => 'ditolak',
            'divalidasi_oleh' => $admin->id,
            'tanggal_validasi' => now(),
        ]);

        $this->assertEquals('ditolak', $report->fresh()->status_validasi);
        // Status barang tetap tersedia
        $this->assertEquals('tersedia', $item->fresh()->status);
    }
}
