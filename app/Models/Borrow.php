<?php

namespace App\Models;

use App\Concerns\HasCachedResource;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $lender
 * @property string $borrower
 * @property string $doc_number
 * @property Carbon|null $date
 */

#[Fillable('lender', 'borrower', 'doc_number', 'date')]
class Borrow extends Model
{
    /** @use HasFactory<\Database\Factories\BorrowFactory> */
    use HasFactory, HasCachedResource;
}
