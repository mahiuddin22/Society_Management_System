@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Plot & Unit Details</h5>

        <a href="{{ route('admin.plot-and-units.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card-body">

        <!-- Plot & Unit Information -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-4">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="4" class="text-center">
                            Plot & Unit Information
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th width="15%">Road</th>
                        <td width="35%">{{ $plotAndUnit->road }}</td>

                        <th width="15%">Holding No.</th>
                        <td width="35%">{{ $plotAndUnit->holding_no }}</td>
                    </tr>

                    <tr>
                        <th>Building Type</th>
                        <td class="text-capitalize">
                            {{ $plotAndUnit->building_type }}
                        </td>

                        <th>Total Flat</th>
                        <td>{{ $plotAndUnit->total_flat }}</td>
                    </tr>

                    <tr>
                        <th>Occupied Flat</th>
                        <td>{{ $plotAndUnit->occupied_flat }}</td>

                        <th>Collection Type</th>
                        <td>{{ $plotAndUnit->collection_type }}</td>
                    </tr>

                    <tr>
                        <th>Contact Person</th>
                        <td>{{ $plotAndUnit->contact_person }}</td>

                        <th>Collection Rate</th>
                        <td>
                            <strong>৳{{ number_format($plotAndUnit->collection_rate, 2) }}</strong>
                        </td>
                    </tr>

                    <tr>
                        <th>Discount</th>
                        <td>
                            <strong>৳{{ number_format($plotAndUnit->discount, 2) }}</strong>
                        </td>

                        <th>Collection Amount</th>
                        <td>
                            <strong class="text-success">
                                ৳{{ number_format($plotAndUnit->collection_amount, 2) }}
                            </strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- Contact Persons -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Contact Persons</h5>

            <span class="badge bg-primary">
                {{ $plotAndUnit->members->count() }} Persons
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">SL</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Email</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($plotAndUnit->members as $member)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $member->name }}
                        </td>

                        <td>
                            {{ $member->number }}
                        </td>

                        <td>
                            {{ $member->email ?: '-' }}
                        </td>

                        <td class="text-end">
                            ৳{{ number_format($member->amount, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No contact persons available.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                @if($plotAndUnit->members->count())
                <tfoot>
                    <tr class="table-light">
                        <th colspan="4" class="text-end">
                            Total Contact Person Amount:
                        </th>

                        <th class="text-end">
                            ৳{{ number_format($plotAndUnit->members->sum('amount'), 2) }}
                        </th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

    </div>
</div>
@endsection