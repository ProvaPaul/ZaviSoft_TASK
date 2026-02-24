@extends('layouts.app')

@section('title', 'Journal Entries')

@section('content')
    <div class="page-header">
        <h2><i class="bi bi-journal-text me-2"></i>Journal Entries</h2>
        <p class="text-muted mb-0">Double-entry accounting ledger — all debits and credits.</p>
    </div>

    <div class="card stat-card">
        <div class="card-body p-0">
            @if($entries->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                    No journal entries found. Create a sale to generate entries.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Account Name</th>
                                <th class="text-end">Debit (TK)</th>
                                <th class="text-end">Credit (TK)</th>
                                <th>Sale Ref</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $currentRef = null; @endphp
                            @foreach($entries as $entry)
                                @if($currentRef !== null && $currentRef !== $entry->reference_id)
                                    <tr>
                                        <td colspan="6" class="p-0">
                                            <hr class="my-0" style="border-top: 2px dashed #dee2e6;">
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">{{ $entry->id }}</td>
                                    <td>{{ $entry->date->format('d M, Y') }}</td>
                                    <td>
                                        @if($entry->debit > 0)
                                            <strong>{{ $entry->account_name }}</strong>
                                        @else
                                            <span class="ps-4">{{ $entry->account_name }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($entry->debit > 0)
                                            <span class="text-success fw-bold">{{ number_format($entry->debit, 2) }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($entry->credit > 0)
                                            <span class="text-danger fw-bold">{{ number_format($entry->credit, 2) }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">Sale #{{ $entry->reference_id }}</span>
                                    </td>
                                </tr>
                                @php $currentRef = $entry->reference_id; @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">Totals:</td>
                                <td class="text-end text-success">{{ number_format($entries->sum('debit'), 2) }}</td>
                                <td class="text-end text-danger">{{ number_format($entries->sum('credit'), 2) }}</td>
                                <td>
                                    @if(abs($entries->sum('debit') - $entries->sum('credit')) < 0.01)
                                        <span class="badge bg-success">Balanced ✓</span>
                                    @else
                                        <span class="badge bg-danger">Unbalanced ✗</span>
                                    @endif
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection