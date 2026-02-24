<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * JournalEntry Model
 *
 * Represents a double-entry accounting journal entry.
 * Each entry records a debit or credit to a specific account.
 */
class JournalEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'account_name',
        'debit',
        'credit',
        'reference_id',
    ];

    protected $casts = [
        'debit'  => 'decimal:2',
        'credit' => 'decimal:2',
        'date'   => 'date',
    ];

    /**
     * A journal entry belongs to a sale (via reference_id).
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'reference_id');
    }
}
