@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
    <div class="page-header">
        <h2><i class="bi bi-plus-circle me-2"></i>Create Product</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card stat-card">
                <div class="card-body p-4">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf

                        {{-- Product Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Product Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="e.g. Widget Pro" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Purchase Price --}}
                        <div class="mb-3">
                            <label for="purchase_price" class="form-label fw-semibold">Purchase Price (TK) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="purchase_price" id="purchase_price"
                                class="form-control @error('purchase_price') is-invalid @enderror"
                                value="{{ old('purchase_price') }}" step="0.01" min="0" placeholder="100.00" required>
                            @error('purchase_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Sell Price --}}
                        <div class="mb-3">
                            <label for="sell_price" class="form-label fw-semibold">Sell Price (TK) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="sell_price" id="sell_price"
                                class="form-control @error('sell_price') is-invalid @enderror"
                                value="{{ old('sell_price') }}" step="0.01" min="0" placeholder="200.00" required>
                            @error('sell_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Opening Stock --}}
                        <div class="mb-4">
                            <label for="stock" class="form-label fw-semibold">Opening Stock <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="stock" id="stock"
                                class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" min="0"
                                placeholder="50" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i> Save Product
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection