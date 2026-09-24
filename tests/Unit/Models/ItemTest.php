<?php

namespace Tests\Unit\Models;

use App\Models\Item;
use App\Models\ItemReport;
use App\Models\ItemTransaction;
use Tests\TestCase;

class ItemTest extends TestCase
{
    public function test_item_can_be_created_with_factory(): void
    {
        $item = Item::factory()->create([
            'kode_bmn' => 'BMN-TEST-001',
            'nama_barang' => 'Laptop ASUS ROG',
        ]);

        $this->assertDatabaseHas('items', [
            'kode_bmn' => 'BMN-TEST-001',
            'nama_barang' => 'Laptop ASUS ROG',
        ]);
        $this->assertNotNull($item->qr_code);
        $this->assertStringContainsString('BMN-TEST-001', $item->qr_code);
    }

    public function test_item_has_many_transactions(): void
    {
        $item = Item::factory()->create();
        $transaction = ItemTransaction::factory()->create([
            'item_id' => $item->id,
        ]);

        $this->assertTrue($item->transactions->contains($transaction));
        $this->assertInstanceOf(ItemTransaction::class, $item->transactions->first());
    }

    public function test_item_has_many_reports(): void
    {
        $item = Item::factory()->create();
        $report = ItemReport::factory()->create([
            'item_id' => $item->id,
        ]);

        $this->assertTrue($item->reports->contains($report));
    }

    public function test_creating_transaction_updates_item_status_to_terpakai(): void
    {
        $item = Item::factory()->create(['status' => 'tersedia']);
        $this->assertEquals('tersedia', $item->fresh()->status);

        ItemTransaction::factory()->create([
            'item_id' => $item->id,
        ]);

        $this->assertEquals('terpakai', $item->fresh()->status);
    }

    public function test_filling_tanggal_kembali_updates_item_status_back_to_tersedia(): void
    {
        $item = Item::factory()->create(['status' => 'tersedia']);

        $transaction = ItemTransaction::factory()->create([
            'item_id' => $item->id,
            'tanggal_kembali' => null,
        ]);

        $this->assertEquals('terpakai', $item->fresh()->status);

        // Pengembalian aset
        $transaction->update([
            'tanggal_kembali' => now()->toDateString(),
        ]);

        $this->assertEquals('tersedia', $item->fresh()->status);
    }
}
