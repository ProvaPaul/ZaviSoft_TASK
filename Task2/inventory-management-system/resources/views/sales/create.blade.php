@extends('layouts.app')

@section('title', 'Create Sale')

@section('content')
    <div class="page-header">
        <h2><i class="bi bi-cart-plus me-2"></i>Create Sale</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card stat-card">
                <div class="card-body p-4">
                    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                        @csrf

                        <div class="row g-3">
                            {{-- Product --}}
                            <div class="col-md-6">
                                <label for="product_id" class="form-label fw-semibold">Product <span
                                        class="text-danger">*</span></label>
                                <select name="product_id" id="product_id"
                                    class="form-select @error('product_id') is-invalid @enderror" required>
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-sell-price="{{ $product->sell_price }}"
                                            data-purchase-price="{{ $product->purchase_price }}"
                                            data-stock="{{ $product->stock }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} (Stock: {{ $product->stock }}, Sell: {{ $product->sell_price }}
                                            TK)
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Quantity --}}
                            <div class="col-md-6">
                                <label for="quantity" class="form-label fw-semibold">Quantity <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="quantity"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                    value="{{ old('quantity') }}" min="1" placeholder="10" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text" id="stockInfo"></div>
                            </div>

                            {{-- Discount --}}
                            <div class="col-md-4">
                                <label for="discount" class="form-label fw-semibold">Discount (TK) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="discount" id="discount"
                                    class="form-control @error('discount') is-invalid @enderror"
                                    value="{{ old('discount', 0) }}" step="0.01" min="0" placeholder="50.00" required>
                                @error('discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- VAT Percent --}}
                            <div class="col-md-4">
                                <label for="vat_percent" class="form-label fw-semibold">VAT % <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="vat_percent" id="vat_percent"
                                    class="form-control @error('vat_percent') is-invalid @enderror"
                                    value="{{ old('vat_percent', 5) }}" step="0.01" min="0" max="100" required>
                                @error('vat_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Paid Amount --}}
                            <div class="col-md-4">
                                <label for="paid_amount" class="form-label fw-semibold">Paid Amount (TK) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="paid_amount" id="paid_amount"
                                    class="form-control @error('paid_amount') is-invalid @enderror"
                                    value="{{ old('paid_amount') }}" step="0.01" min="0" placeholder="1000.00" required>
                                @error('paid_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Date --}}
                            <div class="col-md-6">
                                <label for="date" class="form-label fw-semibold">Sale Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="date" id="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Live Calculation Preview --}}
                        <div class="card bg-light border-0 mt-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3"><i class="bi bi-calculator me-1"></i> Invoice Preview</h6>
                                <div class="row g-2">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="text-muted small">Sale Amount</div>
                                        <div class="fw-bold" id="previewSaleAmount">0.00 TK</div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="text-muted small">After Discount</div>
                                        <div class="fw-bold" id="previewAfterDiscount">0.00 TK</div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="text-muted small">VAT Amount</div>
                                        <div class="fw-bold" id="previewVat">0.00 TK</div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="text-muted small">Total Invoice</div>
                                        <div class="fw-bold text-primary fs-5" id="previewTotal">0.00 TK</div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="text-muted small">Due Amount</div>
                                        <div class="fw-bold text-danger" id="previewDue">0.00 TK</div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="text-muted small">COGS</div>
                                        <div class="fw-bold text-secondary" id="previewCogs">0.00 TK</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i> Record Sale
                            </button>
                            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Live invoice preview calculation
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const discountInput = document.getElementById('discount');
        const vatInput = document.getElementById('vat_percent');
        const paidInput = document.getElementById('paid_amount');
        const stockInfo = document.getElementById('stockInfo');

        function calculate() {
            const option = productSelect.options[productSelect.selectedIndex];
            const sellPrice = parseFloat(option?.dataset.sellPrice || 0);
            const purchasePrice = parseFloat(option?.dataset.purchasePrice || 0);
            const stock = parseInt(option?.dataset.stock || 0);
            const quantity = parseInt(quantityInput.value || 0);
            const discount = parseFloat(discountInput.value || 0);
            const vatPct = parseFloat(vatInput.value || 0);
            const paid = parseFloat(paidInput.value || 0);

            // Show stock info
            if (option?.value) {
                stockInfo.textContent = `Available stock: ${stock} units`;
                stockInfo.className = quantity > stock ? 'form-text text-danger' : 'form-text text-success';
            }

            const saleAmount = sellPrice * quantity;
            const afterDiscount = saleAmount - discount;
            const vatAmount = afterDiscount * (vatPct / 100);
            const totalInvoice = afterDiscount + vatAmount;
            const due = totalInvoice - paid;
            const cogs = purchasePrice * quantity;

            document.getElementById('previewSaleAmount').textContent = saleAmount.toFixed(2) + ' TK';
            document.getElementById('previewAfterDiscount').textContent = afterDiscount.toFixed(2) + ' TK';
            document.getElementById('previewVat').textContent = vatAmount.toFixed(2) + ' TK';
            document.getElementById('previewTotal').textContent = totalInvoice.toFixed(2) + ' TK';
            document.getElementById('previewDue').textContent = due.toFixed(2) + ' TK';
            document.getElementById('previewCogs').textContent = cogs.toFixed(2) + ' TK';
        }

        [productSelect, quantityInput, discountInput, vatInput, paidInput].forEach(el => {
            el.addEventListener('input', calculate);
            el.addEventListener('change', calculate);
        });

        // Trigger initial calculation
        calculate();
    </script>
@endpush