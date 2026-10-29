<?php

namespace App\Models;

use App\Concerns\HasCachedResource;
use App\Concerns\Searchable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $number
 * @property Carbon|null $date
 * @property string $subject
 * @property string $file
 * @property string $type
 * @property string $security
 * @property string $belongs_to
 * @property string $notes
 * @property Carbon|null $revoked_at
 * @property int $box_id
 * @property int $entity_id
 */

#[Fillable('number', 'date', 'subject', 'file', 'type', 'security', 'belongs_to', 'notes', 'revoked_at', 'box_id', 'entity_id')]
class Document extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentFactory> */
    use HasFactory, HasCachedResource, Searchable;

    public function box(): BelongsTo
    {
        return $this->belongsTo(Box::class);
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function followers()
    {
        return self::cached(
            fn() => self::with('box:id,number')
                ->where('belongs_to', $this->number)
                ->latest('id')
                ->get()
                ->toResourceCollection(),
            "document:{$this->id}:followers:all"
        );
    }
}
