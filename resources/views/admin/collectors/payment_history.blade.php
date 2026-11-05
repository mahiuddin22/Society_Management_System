@extends('admin.layouts.app')

@section('content')
<section class="panel active" id="panel-collector-payment-history">
    <div class="card mb-3">
        <div class="card-head">
            <div>
                <h3 class="mb-1">Collector Details</h3>
                <span class="hint">Personal information and assigned roads</span>
            </div>
            <a href="{{ route('admin.collectors.index') }}" class="btn btn-ghost btn-sm">Back to Collectors</a>
        </div>
        <div class="row g-3 px-3 pb-3">
            <div class="col-12 col-md-4">
                <div class="hint small mb-1">Name</div>
                <div class="fw-semibold">{{ $collector->name }}</div>
            </div>
            <div class="col-12 col-md-4">
                <div class="hint small mb-1">Role</div>
                <div class="fw-semibold">{{ ucfirst($collector->role) }}</div>
            </div>
            <div class="col-12 col-md-4">
                <div class="hint small mb-1">Email</div>
                <div class="fw-semibold">{{ $collector->email ?: '—' }}</div>
            </div>
            <div class="col-12 col-md-4">
                <div class="hint small mb-1">Phone</div>
                <div class="fw-semibold">{{ $collector->phone ?: '—' }}</div>
            </div>
            <div class="col-12 col-md-8">
                <div class="hint small mb-1">Assigned Roads</div>
                <div class="d-flex flex-wrap gap-2">
                    @forelse($collector->assignedRoads as $road)
                    <span class="badge neutral">Road {{ ctype_digit((string) $road->number) ? str_pad((string) $road->number, 2, '0', STR_PAD_LEFT) : $road->number }}</span>
                    @empty
                    <span class="hint">No roads are currently assigned.</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head flex-wrap gap-2">
            <div>
                <h3 class="mb-1">Payment History</h3>
                <span class="hint">{{ $payments->total() }} records · Total collected ৳{{ number_format((float) $totalAmount, 2) }}</span>
            </div>
            <form method="GET" action="{{ route('admin.collectors.payment-history', $collector->id) }}" class="d-flex align-items-end flex-wrap gap-2">
                <div>
                    <label for="paymentMonth" class="hint small d-block mb-1">Filter by month</label>
                    <input type="month" id="paymentMonth" name="month" value="{{ request('month') }}" class="form-control form-control-sm">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                @if(request()->filled('month'))
                <a href="{{ route('admin.collectors.payment-history', $collector->id) }}" class="btn btn-ghost btn-sm">Clear</a>
                @endif
            </form>
        </div>
        <div class="px-3">
            @include('admin.report.exports')
        </div>
        <div class="table-wrap">
            <table class="ledger text-nowrap">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Receipt</th>
                        <th>Bill</th>
                        <th>Holding</th>
                        <th>Resident</th>
                        <th>Road</th>
                        <th>Method</th>
                        <th>Transaction</th>
                        <th>Received By</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_date?->format('Y-m-d') ?? '—' }}</td>
                        <td>{{ $payment->payment_number ?? '—' }}</td>
                        <td>{{ $payment->bill?->bill_number ?? '—' }}</td>
                        <td>{{ $payment->bill?->plotAndUnit?->holding_no ?? '—' }}</td>
                        <td>{{ $payment->bill?->plotAndUnit?->name ?? '—' }}</td>
                        <td>{{ $payment->bill?->plotAndUnit?->road?->number ? (ctype_digit((string) $payment->bill->plotAndUnit->road->number) ? str_pad((string) $payment->bill->plotAndUnit->road->number, 2, '0', STR_PAD_LEFT) : $payment->bill->plotAndUnit->road->number) : '—' }}</td>
                        <td>{{ $payment->method ?? '—' }}</td>
                        <td>{{ $payment->transaction_ref ?: '—' }}</td>
                        <td>{{ $payment->collector?->name ?? '—' }}</td>
                        <td>৳{{ number_format((float) $payment->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="text-center py-4">No payment records found for the collector’s assigned roads.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $payments->links('pagination::bootstrap-5') }}</div>
    </div>
</section>
@endsection
