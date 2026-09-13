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
                        <td width="35%">{{ $plotAndUnit->unit_road->name }}</td>

                        <th width="15%">Holding No.</th>
                        <td width="35%">{{ $plotAndUnit->holding_no }}</td>
                    </tr>

                    <tr>
                        <th>Building Type</th>
                        <td class="text-capitalize">
                            {{ $plotAndUnit->plot_type->name }}
                        </td>

                        <th>Total Flat</th>
                        <td>{{ $plotAndUnit->total_flat }}</td>
                    </tr>

                    <tr>
                        <th>Occupied Flat</th>
                        <td>{{ $plotAndUnit->occupied_flat }}</td>

                        <th>Collection Type</th>
                        <td>{{ $plotAndUnit->collection_type ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Collection Rate</th>
                        <td>
                            ৳{{ number_format($plotAndUnit->collection_rate, 2) }}
                        </td>

                        <th>Person Name</th>
                        <td>
                            {{ $plotAndUnit->name ?? 'N/A' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Flat Number</th>
                        <td>
                            {{ $plotAndUnit->flat_no ?? 'N/A' }}
                        </td>

                        <th>Phone Number</th>
                        <td>
                            {{ $plotAndUnit->number ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Person Email</th>
                        <td>
                            {{ $plotAndUnit->email ?? 'N/A' }}
                        </td>

                        <th>Issue Date</th>
                        <td>{{ \Carbon\Carbon::parse($plotAndUnit->date)->format('d-M-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Current Status</th>
                        <td>
                            @if($plotAndUnit->status == 1)
                            <span class="badge green"><i class="dot"></i>Active</span>
                            @else
                            <span class="badge red"><i class="dot"></i>Expired</span>
                            @endif
                        </td>
                        <th>Discount</th>
                        <td>
                            ৳{{ number_format($plotAndUnit->discount, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <th></th>
                        <td></td>

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

    </div>
</div>
@endsection