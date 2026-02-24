@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-box-seam me-2"></i>Products</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Product
        </a>
    </div>

    <div class="card stat-card">
        <div class="card-body p-0">
            @if($products->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    No products found. <a href="{{ route('products.create') }}">Create one</a>.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Purchase Price</th>
                                <th>Sell Price</th>
                                <th>Stock</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td class="fw-semibold">{{ $product->name }}</td>
                                    <td>{{ number_format($product->purchase_price, 2) }} TK</td>
                                    <td>{{ number_format($product->sell_price, 2) }} TK</td>
                                    <td>
                                        @if($product->stock <= 0)
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @elseif($product->stock <= 10)
                                            <span class="badge bg-warning text-dark">{{ $product->stock }} units</span>
                                        @else
                                            <span class="badge bg-success">{{ $product->stock }} units</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->created_at->format('d M, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection