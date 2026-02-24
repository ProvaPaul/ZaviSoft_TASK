<?php

/**
 * Test script: Creates a sale matching the business scenario and verifies
 * all journal entries are balanced.
 *
 * Run with: php artisan tinker test_sale.php
 */

$product = App\Models\Product::find(1);
echo "Product: {$product->name} | Stock: {$product->stock} | Sell: {$product->sell_price}\n";

$quantity   = 10;
$discount   = 50;
$vatPercent = 5;
$paidAmount = 1000;
$date       = '2026-02-24';

$saleAmount    = $product->sell_price * $quantity;
$afterDiscount = $saleAmount - $discount;
$vatAmount     = round($afterDiscount * ($vatPercent / 100), 2);
$totalInvoice  = round($afterDiscount + $vatAmount, 2);
$dueAmount     = round($totalInvoice - $paidAmount, 2);
$cost          = $product->purchase_price * $quantity;

echo "Sale Amount:    {$saleAmount}\n";
echo "After Discount: {$afterDiscount}\n";
echo "VAT Amount:     {$vatAmount}\n";
echo "Total Invoice:  {$totalInvoice}\n";
echo "Due Amount:     {$dueAmount}\n";
echo "COGS:           {$cost}\n";
echo "---\n";

// Already created via tinker attempt, skip if sale exists
if (App\Models\Sale::count() === 0) {
    $sale = App\Models\Sale::create([
        'product_id'   => 1,
        'quantity'     => $quantity,
        'discount'     => $discount,
        'vat_percent'  => $vatPercent,
        'total_amount' => $totalInvoice,
        'paid_amount'  => $paidAmount,
        'due_amount'   => $dueAmount,
        'date'         => $date,
    ]);

    $product->decrement('stock', $quantity);

    $service = new App\Services\AccountingService();
    $service->createJournalEntries($sale, $afterDiscount, $vatAmount, $totalInvoice, $cost);

    echo "Sale created: #{$sale->id}\n";
} else {
    $sale = App\Models\Sale::first();
    echo "Sale already exists: #{$sale->id}\n";
}

echo "Stock after sale: " . $product->fresh()->stock . "\n";
echo "Journal entries:  " . App\Models\JournalEntry::where('reference_id', $sale->id)->count() . "\n";

$totalDebits  = App\Models\JournalEntry::where('reference_id', $sale->id)->sum('debit');
$totalCredits = App\Models\JournalEntry::where('reference_id', $sale->id)->sum('credit');
echo "Total Debits:  {$totalDebits}\n";
echo "Total Credits: {$totalCredits}\n";
echo "Balanced: " . (abs($totalDebits - $totalCredits) < 0.01 ? 'YES ✓' : 'NO ✗') . "\n";
