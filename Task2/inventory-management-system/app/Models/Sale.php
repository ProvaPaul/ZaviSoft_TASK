<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Sale Model
 *
 * Represents a sale transaction with calculated amounts and payment tracking.
 */
class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'discount',
        'vat_percent',
        'total_amount',
        'paid_amount',
        'due_amount',
        'date',
    ];

    protected $casts = [
        'discount'     => 'decimal:2',
        'vat_percent'  => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'due_amount'   => 'decimal:2',
        'date'         => 'date',
    ];

    /**
     * A sale belongs to a product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * A sale has many journal entries.
     */
    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class, 'reference_id');
    }
}
