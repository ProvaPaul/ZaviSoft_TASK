<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Services\AccountingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * SaleController
 *
 * Handles sale creation with full business logic:
 *   - Calculates sale amounts, discount, VAT, due
 *   - Reduces product stock
 *   - Creates double-entry journal entries via AccountingService
 */
class SaleController extends Controller
{
    protected AccountingService $accountingService;

    public function __construct(AccountingService $accountingService)
    {
        $this->accountingService = $accountingService;
    }

    /**
     * Display a listing of all sales.
     */
    public function index()
    {
        $sales = Sale::with('product')->latest()->get();
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created sale.
     *
     * Business Logic:
     *   sale_amount   = sell_price × quantity
     *   after_discount = sale_amount - discount
     *   vat_amount    = vat_percent% of after_discount
     *   total_invoice = after_discount + vat_amount
     *   due_amount    = total_invoice - paid_amount
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'discount'    => 'required|numeric|min:0',
            'vat_percent' => 'required|numeric|min:0|max:100',
            'paid_amount' => 'required|numeric|min:0',
            'date'        => 'required|date',
        ]);

        // Fetch product
        $product = Product::findOrFail($validated['product_id']);

        // ── Stock Validation ──────────────────────────────────────────
        if ($validated['quantity'] > $product->stock) {
            return back()->withErrors([
                'quantity' => "Insufficient stock. Available: {$product->stock} units.",
            ])->withInput();
        }

        // ── Financial Calculations ────────────────────────────────────
        $saleAmount    = $product->sell_price * $validated['quantity'];       // gross sale
        $afterDiscount = $saleAmount - $validated['discount'];                // net sale
        $vatAmount     = round($afterDiscount * ($validated['vat_percent'] / 100), 2);  // VAT
        $totalInvoice  = round($afterDiscount + $vatAmount, 2);               // invoice total
        $dueAmount     = round($totalInvoice - $validated['paid_amount'], 2); // remaining due

        // Validate paid amount does not exceed invoice
        if ($validated['paid_amount'] > $totalInvoice) {
            return back()->withErrors([
                'paid_amount' => "Paid amount cannot exceed the total invoice of {$totalInvoice} TK.",
            ])->withInput();
        }

        // ── Cost of Goods Sold ────────────────────────────────────────
        $cost = $product->purchase_price * $validated['quantity'];

        // ── Wrap everything in a DB transaction ───────────────────────
        DB::transaction(function () use (
            $validated, $product, $totalInvoice, $dueAmount,
            $afterDiscount, $vatAmount, $cost
        ) {
            // 1. Create the sale record
            $sale = Sale::create([
                'product_id'   => $validated['product_id'],
                'quantity'     => $validated['quantity'],
                'discount'     => $validated['discount'],
                'vat_percent'  => $validated['vat_percent'],
                'total_amount' => $totalInvoice,
                'paid_amount'  => $validated['paid_amount'],
                'due_amount'   => $dueAmount,
                'date'         => $validated['date'],
            ]);

            // 2. Reduce product stock
            $product->decrement('stock', $validated['quantity']);

            // 3. Create double-entry journal entries
            $this->accountingService->createJournalEntries(
                $sale,
                $afterDiscount,
                $vatAmount,
                $totalInvoice,
                $cost
            );
        });

        return redirect()->route('sales.index')
                         ->with('success', 'Sale recorded successfully with journal entries.');
    }
}
