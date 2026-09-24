<?php

namespace App\Observers;

use App\Models\ItemTransaction;
use App\Services\AuditService;

class ItemTransactionObserver
{
    public function created(ItemTransaction $transaction): void
    {
        AuditService::log('create', 'ItemTransaction', $transaction->id, $transaction->getAttributes());
    }

    public function updated(ItemTransaction $transaction): void
    {
        AuditService::log('update', 'ItemTransaction', $transaction->id, $transaction->getChanges());
    }

    public function deleted(ItemTransaction $transaction): void
    {
        AuditService::log('delete', 'ItemTransaction', $transaction->id);
    }
}
