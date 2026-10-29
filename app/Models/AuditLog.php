<?php

namespace App\Models;

use App\Concerns\Searchable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $action
 * @property string $type
 * @property string $number
 */

#[Fillable('user_id', 'name', 'action', 'type', 'number')]
class AuditLog extends Model
{
    /** @use HasFactory<\Database\Factories\AuditLogFactory> */
    use HasFactory, Searchable;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
