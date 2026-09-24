<?php

namespace App\Services;

use App\Exceptions\ItemNotAvailableException;
use App\Exceptions\ItemNotFoundException;
use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

class ItemService
{
    /**
     * Create a new BMN item.
     */
    public function createItem(array $data): Item
    {
        return Item::create($data);
    }

    /**
     * Find item by kode BMN or throw exception.
     *
     * @throws ItemNotFoundException
     */
    public function findByKodeBmn(string $kodeBmn): Item
    {
        $item = Item::where('kode_bmn', $kodeBmn)->first();

        if (! $item) {
            throw new ItemNotFoundException("Barang dengan kode BMN '{$kodeBmn}' tidak ditemukan.");
        }

        return $item;
    }

    /**
     * Ensure item is available or throw exception.
     *
     * @throws ItemNotAvailableException
     */
    public function ensureAvailable(Item $item): void
    {
        if ($item->status !== 'tersedia') {
            throw new ItemNotAvailableException("Barang '{$item->nama_barang}' ({$item->kode_bmn}) berstatus {$item->status}.");
        }
    }

    /**
     * Update item status/condition.
     */
    public function updateStatus(Item $item, string $status): Item
    {
        $item->update(['status' => $status]);

        return $item->fresh();
    }

    /**
     * Get QR Code target URL for an item.
     */
    public function getQrCodeUrl(Item $item): string
    {
        return url('/scan/'.$item->kode_bmn);
    }

    /**
     * Retrieve all available items.
     */
    public function getAvailableItems(): Collection
    {
        return Item::where('status', 'tersedia')->get();
    }
}
