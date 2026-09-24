<?php

namespace Tests\Unit\Services;

use App\Exceptions\ItemNotAvailableException;
use App\Exceptions\ItemNotFoundException;
use App\Models\Item;
use App\Services\ItemService;
use Tests\TestCase;

class ItemServiceTest extends TestCase
{
    private ItemService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ItemService;
    }

    public function test_find_by_kode_bmn_returns_item(): void
    {
        $item = Item::factory()->create(['kode_bmn' => 'BMN-SRV-01']);

        $found = $this->service->findByKodeBmn('BMN-SRV-01');

        $this->assertEquals($item->id, $found->id);
    }

    public function test_find_by_kode_bmn_throws_exception_when_not_found(): void
    {
        $this->expectException(ItemNotFoundException::class);
        $this->service->findByKodeBmn('BMN-NONEXISTENT');
    }

    public function test_ensure_available_throws_exception_when_status_is_terpakai(): void
    {
        $item = Item::factory()->terpakai()->create();

        $this->expectException(ItemNotAvailableException::class);
        $this->service->ensureAvailable($item);
    }

    public function test_update_status_updates_item_in_database(): void
    {
        $item = Item::factory()->create(['status' => 'tersedia']);

        $updated = $this->service->updateStatus($item, 'rusak');

        $this->assertEquals('rusak', $updated->status);
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'status' => 'rusak',
        ]);
    }
}
