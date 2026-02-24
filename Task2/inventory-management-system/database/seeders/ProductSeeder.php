<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * ProductSeeder
 *
 * Seeds the database with sample products matching the business scenario:
 *   - Purchase Price: 100 TK
 *   - Sell Price: 200 TK
 *   - Opening Stock: 50 units
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Primary sample product per the business scenario
        Product::create([
            'name'           => 'Widget Pro',
            'purchase_price' => 100.00,
            'sell_price'     => 200.00,
            'stock'          => 50,
        ]);

        // Additional sample products for demonstration
        Product::create([
            'name'           => 'Gadget X',
            'purchase_price' => 150.00,
            'sell_price'     => 350.00,
            'stock'          => 30,
        ]);

        Product::create([
            'name'           => 'Accessory Z',
            'purchase_price' => 50.00,
            'sell_price'     => 120.00,
            'stock'          => 100,
        ]);
    }
}
