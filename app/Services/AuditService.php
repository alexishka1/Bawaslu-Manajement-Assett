<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AuditService
{
    /**
     * Record an audit log entry for model state changes or critical actions.
     */
    public static function log(string $action, string $model, int|string $id, ?array $changes = null): void
    {
        Log::channel('audit')->info("Action: {$action}", [
            'user_id' => auth()->id() ?? 'System/Guest',
            'user_name' => auth()->user()?->name ?? 'Guest',
            'model' => $model,
            'model_id' => $id,
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
