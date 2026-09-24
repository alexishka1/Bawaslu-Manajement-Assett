<?php

namespace App\Observers;

use App\Models\Item;
use App\Services\AuditService;

class ItemObserver
{
    public function created(Item $item): void
    {
        AuditService::log('create', 'Item', $item->id, $item->getAttributes());
    }

    public function updated(Item $item): void
    {
        AuditService::log('update', 'Item', $item->id, $item->getChanges());
    }

    public function deleted(Item $item): void
    {
        AuditService::log('delete', 'Item', $item->id);
    }
}
