<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $box_name
 * @property string $box_number
 * @property Carbon|null $box_date
 */

#[Fillable('box_name', 'box_number', 'box_date')]
class Box extends Model
{
    /** @use HasFactory<\Database\Factories\BoxFactory> */
    use HasFactory;

    public function docs(): HasMany
    {
        return $this->hasMany(Doc::class);
    }
}
