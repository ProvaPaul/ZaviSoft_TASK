<?php

namespace App\Services;

use App\Models\JournalEntry;
use App\Models\Sale;

/**
 * AccountingService
 *
 * Handles all double-entry accounting journal entries for sales transactions.
 *
 * Double Entry Principle:
 *   - Every transaction must have equal debits and credits.
 *   - Assets & Expenses increase with Debit.
 *   - Liabilities, Equity & Revenue increase with Credit.
 */
class AccountingService
{
    /**
     * Create all journal entries for a completed sale.
     *
     * Entry 1 – Revenue Recognition:
     *   Debit:  Accounts Receivable  (total_invoice)
     *   Credit: Sales Revenue         (after_discount)
     *   Credit: VAT Payable           (vat_amount)
     *
     * Entry 2 – Cash Receipt (if payment received):
     *   Debit:  Cash                  (paid_amount)
     *   Credit: Accounts Receivable   (paid_amount)
     *
     * Entry 3 – Cost of Goods Sold:
     *   Debit:  Cost of Goods Sold    (cost)
     *   Credit: Inventory             (cost)
     *
     * @param  Sale   $sale
     * @param  float  $afterDiscount   sale_amount minus discount
     * @param  float  $vatAmount       VAT on discounted amount
     * @param  float  $totalInvoice    afterDiscount + vatAmount
     * @param  float  $cost            purchase_price × quantity
     * @return void
     */
    public function createJournalEntries(
        Sale  $sale,
        float $afterDiscount,
        float $vatAmount,
        float $totalInvoice,
        float $cost
    ): void {
        $date        = $sale->date;
        $referenceId = $sale->id;

        // ── Entry 1: Revenue Recognition ──────────────────────────────
        // Debit Accounts Receivable for the full invoice amount
        JournalEntry::create([
            'date'         => $date,
            'account_name' => 'Accounts Receivable',
            'debit'        => $totalInvoice,
            'credit'       => 0,
            'reference_id' => $referenceId,
        ]);

        // Credit Sales Revenue for the after-discount sale value
        JournalEntry::create([
            'date'         => $date,
            'account_name' => 'Sales Revenue',
            'debit'        => 0,
            'credit'       => $afterDiscount,
            'reference_id' => $referenceId,
        ]);

        // Credit VAT Payable for the tax collected
        JournalEntry::create([
            'date'         => $date,
            'account_name' => 'VAT Payable',
            'debit'        => 0,
            'credit'       => $vatAmount,
            'reference_id' => $referenceId,
        ]);

        // ── Entry 2: Cash Receipt (only if customer paid something) ──
        if ($sale->paid_amount > 0) {
            // Debit Cash for money received
            JournalEntry::create([
                'date'         => $date,
                'account_name' => 'Cash',
                'debit'        => $sale->paid_amount,
                'credit'       => 0,
                'reference_id' => $referenceId,
            ]);

            // Credit Accounts Receivable to reduce the receivable
            JournalEntry::create([
                'date'         => $date,
                'account_name' => 'Accounts Receivable',
                'debit'        => 0,
                'credit'       => $sale->paid_amount,
                'reference_id' => $referenceId,
            ]);
        }

        // ── Entry 3: Cost of Goods Sold ───────────────────────────────
        // Debit COGS (expense increases)
        JournalEntry::create([
            'date'         => $date,
            'account_name' => 'Cost of Goods Sold',
            'debit'        => $cost,
            'credit'       => 0,
            'reference_id' => $referenceId,
        ]);

        // Credit Inventory (asset decreases)
        JournalEntry::create([
            'date'         => $date,
            'account_name' => 'Inventory',
            'debit'        => 0,
            'credit'       => $cost,
            'reference_id' => $referenceId,
        ]);
    }
}
