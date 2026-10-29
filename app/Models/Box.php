<?php

namespace App\Models;

use App\Concerns\HasCachedResource;
use App\Concerns\Searchable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $number
 * @property Carbon|null $date
 */

#[Fillable('name', 'number', 'date')]
class Box extends Model
{
    /** @use HasFactory<\Database\Factories\BoxFactory> */
    use HasFactory, HasCachedResource, Searchable;

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
