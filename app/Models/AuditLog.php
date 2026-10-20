<?php

namespace App\Models;

use App\Concerns\HasCachedResource;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $username
 * @property string $action
 * @property string $target_type
 * @property string $target_number
 */

#[Fillable('user_id', 'username', 'action', 'target_type', 'target_number')]
class AuditLog extends Model
{
    /** @use HasFactory<\Database\Factories\AuditLogFactory> */
    use HasFactory, HasCachedResource;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
