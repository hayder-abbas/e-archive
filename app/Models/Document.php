<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $number
 * @property string $subject
 * @property Carbon|null $date
 * @property string $file
 * @property string $type
 * @property string $security
 * @property string $description
 * @property int $box_id
 * @property int $entity_id
 */

#[Fillable('number', 'subject', 'date', 'file', 'type', 'security', 'description', 'box_id', 'entity_id')]
class Document extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentFactory> */
    use HasFactory, SoftDeletes;

    public function box(): BelongsTo
    {
        return $this->belongsTo(Box::class);
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }
}
