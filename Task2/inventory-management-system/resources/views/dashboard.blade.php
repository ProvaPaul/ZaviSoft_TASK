@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
    </div>

    <!-- ── Summary Cards ──────────────────────────────────────────────── -->
    <div class="row g-3 mb-4">
        {{-- Total Products --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Products</div>
                        <div class="fw-bold fs-4">{{ $totalProducts }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Sales --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-box bg-success bg-opacity-10 text-success">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Sales</div>
                        <div class="fw-bold fs-4">{{ $totalSales }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-box bg-info bg-opacity-10 text-info">
                        <i class="bi bi-currency-exchange"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Revenue</div>
                        <div class="fw-bold fs-4">{{ number_format($totalRevenue, 2) }} TK</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gross Profit --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Gross Profit</div>
                        <div class="fw-bold fs-4">{{ number_format($grossProfit, 2) }} TK</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Second Row Cards ───────────────────────────────────────────── -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-box bg-success bg-opacity-10 text-success">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Cash Received</div>
                        <div class="fw-bold fs-5">{{ number_format($totalCash, 2) }} TK</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-box bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Due Amount</div>
                        <div class="fw-bold fs-5">{{ number_format($totalDue, 2) }} TK</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-box bg-secondary bg-opacity-10 text-secondary">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total VAT Payable</div>
                        <div class="fw-bold fs-5">{{ number_format($totalVat, 2) }} TK</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Recent Sales ───────────────────────────────────────────────── -->
    <div class="card stat-card">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Recent Sales</h5>
            <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body p-0">
            @if($recentSales->isEmpty())
                <div class="text-center text-muted py-4">No sales recorded yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSales as $sale)
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>{{ number_format($sale->total_amount, 2) }} TK</td>
                                    <td class="text-success">{{ number_format($sale->paid_amount, 2) }} TK</td>
                                    <td class="text-danger">{{ number_format($sale->due_amount, 2) }} TK</td>
                                    <td>{{ $sale->date->format('d M, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection