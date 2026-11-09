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

    <div class="card mb-3">
        <div class="card-head">
            <div>
                <h3 class="mb-1">12-Month Collection Performance</h3>
                <span class="hint">{{ $performanceMonths->first()['label'] }} – {{ $performanceMonths->last()['label'] }} · Payments are credited to the month of the bill, including later payments.</span>
            </div>
        </div>

        <div class="row g-3 px-3 pb-3">
            <div class="col-12 col-md-3">
                <div class="stat-card h-100">
                    <div class="label">Total Target</div>
                    <div class="value"><span class="sym">৳</span>{{ number_format($performanceSummary['target'], 2) }}</div>
                    <div class="delta">Across the last 12 billing months</div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="stat-card gold h-100">
                    <div class="label">Collected</div>
                    <div class="value"><span class="sym">৳</span>{{ number_format($performanceSummary['collected'], 2) }}</div>
                    <div class="delta">Payments against those monthly bills</div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="stat-card due h-100">
                    <div class="label">Remaining Due</div>
                    <div class="value"><span class="sym">৳</span>{{ number_format($performanceSummary['due'], 2) }}</div>
                    <div class="delta">Uncollected from the 12-month target</div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="stat-card h-100">
                    <div class="label">Overall Performance</div>
                    <div class="value">{{ number_format($performanceSummary['rate'], 1) }}%</div>
                    <div class="progress mt-2" role="progressbar" aria-label="Overall collection performance" aria-valuenow="{{ round($performanceSummary['rate']) }}" aria-valuemin="0" aria-valuemax="100" style="height:7px;">
                        <div class="progress-bar bg-success" style="width:{{ $performanceSummary['rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-wrap">
            <table class="ledger text-nowrap">
                <thead>
                    <tr>
                        <th>Billing Month</th>
                        <th>Target</th>
                        <th>Collected</th>
                        <th>Remaining Due</th>
                        <th>Performance</th>
                        <th>Time to Collect Full Target</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($performanceMonths as $month)
                    <tr>
                        <td>{{ $month['label'] }}</td>
                        <td>৳{{ number_format($month['target'], 2) }}</td>
                        <td>৳{{ number_format($month['collected'], 2) }}</td>
                        <td>৳{{ number_format($month['due'], 2) }}</td>
                        <td>
                            @if($month['target'] > 0)
                            <div class="d-flex align-items-center gap-2">
                                <span>{{ number_format($month['performance'], 1) }}%</span>
                                <div class="progress flex-grow-1" style="height:6px; min-width:55px; max-width:90px;">
                                    <div class="progress-bar bg-success" style="width:{{ $month['performance'] }}%"></div>
                                </div>
                            </div>
                            @else
                            <span class="hint">—</span>
                            @endif
                        </td>
                        <td>{{ $month['completion_status'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
