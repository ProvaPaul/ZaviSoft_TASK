<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product Model
 *
 * Represents a product in the inventory with purchase price, sell price, and stock.
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'purchase_price',
        'sell_price',
        'stock',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sell_price'     => 'decimal:2',
        'stock'          => 'integer',
    ];

    /**
     * A product has many sales.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
