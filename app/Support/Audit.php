<?php

namespace App\Support;

use App\Models\AuditLog;

class Audit {
    public static function log(string $action, $auditable, array $meta = [], ?string $actor = null): void {
        AuditLog::create([
            'actor' => $actor ?? (auth()->user()->email ?? 'system'),
            'action' => $action,
            'auditable_type' => get_class($auditable),
            'auditable_id' => $auditable->id,
            'meta' => $meta,
            'created_at' => now(),
        ]);
    }
}
