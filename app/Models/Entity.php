<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */

#[Fillable('name')]
class Entity extends Model
{
    /** @use HasFactory<\Database\Factories\EntityFactory> */
    use HasFactory;

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
