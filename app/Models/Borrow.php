<?php

namespace App\Models;

use App\Concerns\Searchable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $lender
 * @property string $borrower
 * @property string $number
 * @property Carbon|null $date
 */

#[Fillable('lender', 'borrower', 'number', 'date')]
class Borrow extends Model
{
    /** @use HasFactory<\Database\Factories\BorrowFactory> */
    use HasFactory, Searchable;
}
