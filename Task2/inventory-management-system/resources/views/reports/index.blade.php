@extends('layouts.app')

@section('title', 'Financial Report')

@section('content')
    <div class="page-header">
        <h2><i class="bi bi-bar-chart-line me-2"></i>Financial Report</h2>
        <p class="text-muted mb-0">Date-wise financial summary with double-entry data.</p>
    </div>

    <!-- ── Date Filter Form ───────────────────────────────────────────── -->
    <div class="card stat-card mb-4">
        <div class="card-body">
            <form action="{{ route('reports.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="from_date" class="form-label fw-semibold">From Date</label>
                        <input type="date" name="from_date" id="from_date"
                            class="form-control @error('from_date') is-invalid @enderror" value="{{ $fromDate ?? '' }}"
                            required>
                        @error('from_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="to_date" class="form-label fw-semibold">To Date</label>
                        <input type="date" name="to_date" id="to_date"
                            class="form-control @error('to_date') is-invalid @enderror" value="{{ $toDate ?? '' }}"
                            required>
                        @error('to_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Generate Report
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ── Report Results ─────────────────────────────────────────────── -->
    @if($data)
        <div class="row g-3 mb-4">
            {{-- Total Sales --}}
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card h-100 border-start border-4 border-primary">
                    <div class="card-body">
                        <div class="text-muted small text-uppercase">Total Sales</div>
                        <div class="fw-bold fs-4 text-primary">{{ number_format($data->total_sales, 2) }} TK</div>
                        <div class="text-muted small mt-1">Sum of all invoices</div>
                    </div>
                </div>
            </div>

            {{-- Total Expense (COGS) --}}
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card h-100 border-start border-4 border-danger">
                    <div class="card-body">
                        <div class="text-muted small text-uppercase">Total Expense (COGS)</div>
                        <div class="fw-bold fs-4 text-danger">{{ number_format($data->total_expense, 2) }} TK</div>
                        <div class="text-muted small mt-1">Cost of goods sold</div>
                    </div>
                </div>
            </div>

            {{-- Total VAT Payable --}}
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card h-100 border-start border-4 border-warning">
                    <div class="card-body">
                        <div class="text-muted small text-uppercase">Total VAT Payable</div>
                        <div class="fw-bold fs-4 text-warning">{{ number_format($data->total_vat, 2) }} TK</div>
                        <div class="text-muted small mt-1">Tax collected</div>
                    </div>
                </div>
            </div>

            {{-- Total Due Amount --}}
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card h-100 border-start border-4 border-secondary">
                    <div class="card-body">
                        <div class="text-muted small text-uppercase">Total Due Amount</div>
                        <div class="fw-bold fs-4 text-secondary">{{ number_format($data->total_due, 2) }} TK</div>
                        <div class="text-muted small mt-1">Outstanding receivables</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detailed Summary Table --}}
        <div class="card stat-card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold"><i class="bi bi-table me-2"></i>Detailed Summary</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Metric</th>
                            <th class="text-end">Amount (TK)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="bi bi-cart-check text-primary me-2"></i>Total Sales (Invoices)</td>
                            <td class="text-end fw-bold">{{ number_format($data->total_sales, 2) }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-cash-stack text-success me-2"></i>Sales Revenue (After Discount)</td>
                            <td class="text-end fw-bold text-success">{{ number_format($data->total_revenue, 2) }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-dash-circle text-danger me-2"></i>Cost of Goods Sold (COGS)</td>
                            <td class="text-end fw-bold text-danger">{{ number_format($data->total_expense, 2) }}</td>
                        </tr>
                        <tr class="table-info">
                            <td><i class="bi bi-graph-up-arrow text-info me-2"></i><strong>Gross Profit</strong></td>
                            <td class="text-end fw-bold fs-5 text-info">{{ number_format($data->gross_profit, 2) }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-receipt text-warning me-2"></i>VAT Payable</td>
                            <td class="text-end fw-bold">{{ number_format($data->total_vat, 2) }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-wallet2 text-success me-2"></i>Cash Received</td>
                            <td class="text-end fw-bold text-success">{{ number_format($data->total_cash, 2) }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-exclamation-triangle text-danger me-2"></i>Due Amount</td>
                            <td class="text-end fw-bold text-danger">{{ number_format($data->total_due, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @elseif(request()->has('from_date'))
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-1"></i> No data found for the selected date range.
        </div>
    @else
        <div class="text-center text-muted py-5">
            <i class="bi bi-calendar-range fs-1 d-block mb-3"></i>
            <p>Select a date range above to generate your financial report.</p>
        </div>
    @endif
@endsection