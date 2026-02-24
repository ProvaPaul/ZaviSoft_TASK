<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\Product;
use App\Models\Sale;

/**
 * DashboardController
 *
 * Shows a summary dashboard with key metrics.
 */
class DashboardController extends Controller
{
    /**
     * Display the application dashboard.
     */
    public function index()
    {
        $totalProducts   = Product::count();
        $totalSales      = Sale::count();
        $totalRevenue    = Sale::sum('total_amount');
        $totalDue        = Sale::sum('due_amount');
        $totalCash       = Sale::sum('paid_amount');
        $totalCogs       = JournalEntry::where('account_name', 'Cost of Goods Sold')->sum('debit');
        $totalVat        = JournalEntry::where('account_name', 'VAT Payable')->sum('credit');
        $grossProfit     = $totalRevenue - $totalCogs - $totalVat;

        $recentSales = Sale::with('product')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalProducts', 'totalSales', 'totalRevenue',
            'totalDue', 'totalCash', 'totalCogs', 'totalVat',
            'grossProfit', 'recentSales'
        ));
    }
}
