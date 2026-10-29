<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Models\AuditLog;
use App\Models\User;

class AuditLogger
{
    public function __invoke(
        User $user,
        AuditAction $action,
        AuditTarget $type,
        string $number
    ): AuditLog {
        return AuditLog::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'action' => $action,
            'type' => $type,
            'number' => $number,
        ]);
    }
}
