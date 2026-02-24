<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\Sale;
use Illuminate\Http\Request;

/**
 * ReportController
 *
 * Generates date-wise financial reports:
 *   - Total Sales
 *   - Total Expense (COGS)
 *   - Total VAT Payable
 *   - Total Due Amount
 *   - Gross Profit
 */
class ReportController extends Controller
{
    /**
     * Show the financial report page with optional date filter.
     */
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate   = $request->input('to_date');

        $data = null;

        if ($fromDate && $toDate) {
            // Validate date inputs
            $request->validate([
                'from_date' => 'required|date',
                'to_date'   => 'required|date|after_or_equal:from_date',
            ]);

            // ── Total Sales (sum of total_amount from sales table) ────
            $totalSales = Sale::whereBetween('date', [$fromDate, $toDate])
                              ->sum('total_amount');

            // ── Total COGS (sum of debit where account = COGS) ────────
            $totalExpense = JournalEntry::where('account_name', 'Cost of Goods Sold')
                                        ->whereBetween('date', [$fromDate, $toDate])
                                        ->sum('debit');

            // ── Total VAT Payable (sum of credit where account = VAT) ─
            $totalVat = JournalEntry::where('account_name', 'VAT Payable')
                                    ->whereBetween('date', [$fromDate, $toDate])
                                    ->sum('credit');

            // ── Total Due Amount ──────────────────────────────────────
            $totalDue = Sale::whereBetween('date', [$fromDate, $toDate])
                            ->sum('due_amount');

            // ── Total Cash Received ───────────────────────────────────
            $totalCash = Sale::whereBetween('date', [$fromDate, $toDate])
                             ->sum('paid_amount');

            // ── Gross Profit = Sales Revenue - COGS ───────────────────
            $totalRevenue = JournalEntry::where('account_name', 'Sales Revenue')
                                        ->whereBetween('date', [$fromDate, $toDate])
                                        ->sum('credit');
            $grossProfit = $totalRevenue - $totalExpense;

            $data = (object) [
                'total_sales'   => $totalSales,
                'total_expense' => $totalExpense,
                'total_vat'     => $totalVat,
                'total_due'     => $totalDue,
                'total_cash'    => $totalCash,
                'gross_profit'  => $grossProfit,
                'total_revenue' => $totalRevenue,
            ];
        }

        return view('reports.index', compact('data', 'fromDate', 'toDate'));
    }
}
