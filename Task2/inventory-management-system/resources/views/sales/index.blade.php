@extends('layouts.app')

@section('title', 'Sales')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-cart-check me-2"></i>Sales</h2>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> New Sale
        </a>
    </div>

    <div class="card stat-card">
        <div class="card-body p-0">
            @if($sales->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                    No sales recorded yet. <a href="{{ route('sales.create') }}">Create one</a>.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Discount</th>
                                <th>VAT %</th>
                                <th>Total Amount</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td class="fw-semibold">{{ $sale->product->name }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>{{ number_format($sale->discount, 2) }} TK</td>
                                    <td>{{ $sale->vat_percent }}%</td>
                                    <td class="fw-bold">{{ number_format($sale->total_amount, 2) }} TK</td>
                                    <td class="text-success">{{ number_format($sale->paid_amount, 2) }} TK</td>
                                    <td>
                                        @if($sale->due_amount > 0)
                                            <span class="text-danger fw-bold">{{ number_format($sale->due_amount, 2) }} TK</span>
                                        @else
                                            <span class="badge bg-success">Paid</span>
                                        @endif
                                    </td>
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