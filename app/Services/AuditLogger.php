<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Models\AuditLog;
use App\Models\User;

class AuditLogger
{
    public static function record(
        User $user,
        AuditAction $action,
        AuditTarget $targetType,
        string $targetNumber
    ): AuditLog {
        return AuditLog::create([
            'user_id' => $user->id,
            'username' => $user->name,
            'action' => $action,
            'target_type' => $targetType,
            'target_number' => $targetNumber,
        ]);
    }
}
