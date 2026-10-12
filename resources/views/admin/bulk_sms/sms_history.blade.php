@extends('admin.layouts.app')

@section('content')
<div class="p-3 ">
    <form action="{{ url()->current() }}" method="GET">

        <div class="row g-2 mb-4">

            <div class="col-md-3">
                <label class="form-label">Mobile No</label>
                <input type="text" name="mobile_no" class="form-control" value="{{ request('mobile_no') }}" placeholder="Mobile number">
            </div>

            <!-- <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="api_status" class="form-select">
                    <option value="">All Status</option>
                    <option value="3" {{ request('api_status') == '3' ? 'selected' : '' }}>Sent</option>
                    <option value="0" {{ request('api_status') == '0' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div> -->

            <div class="col-md-2">
                <label class="form-label">Date From</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Date To</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>

            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    Filter
                </button>

                <a href="{{ url()->current() }}" class="btn btn-secondary">
                    Reset
                </a>
            </div>

        </div>

    </form>
</div>

<div class="card mb-3">

    <div class="card-head">
        <div>
            <h3>Campaign History</h3>
            <span class="hint">SMS delivery summary</span>
        </div>
        @if(hasPermission('sms_history','download'))
        <button class="btn btn-primary btn-sm"> <i class="bi bi-download"></i> Download</button>
        @endif
    </div>


    <div class="table-wrap">

        <table class="ledger text-nowrap">

            <thead>
                <tr>
                    <th>SMS Type</th>
                    <th>Mobile No</th>
                    <th>Message</th>
                    <th>Character Count</th>
                    <th>Status</th>
                    <th>Request Time</th>
                </tr>
            </thead>

            <tbody>

                @forelse($sms_histories as $item)

                <tr>

                    <td>{{ $item->sms_type }}</td>
                    <td>{{ $item->phone_no ?? '-' }}</td>

                    <td>{{ $item->sms_type == 'custom' ? $item->custom_sms : $item->draftsms->message ?? 'N/A' }}</td>

                    <td>{{ strlen($item->message) }} chars</td>

                    <td>
                        <span class="badge {{ $item->status == 'sent' ? 'green' : 'red' }}">
                            {{ $item->status == 'sent' ? 'Sent' : 'Canceled' }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($item->created_at) }}
                        <br>
                        <strong>
                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                        </strong>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center">
                        No SMS history found.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        @if(($allsms['last_page'] ?? 1) > 1)

        <div class="mt-3 d-flex justify-content-end">

            <nav>
                <ul class="pagination">

                    @if($allsms['current_page'] > 1)

                    <li class="page-item">
                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $allsms['current_page'] - 1]) }}">
                            Previous
                        </a>
                    </li>

                    @endif

                    @for($page = 1; $page <= $allsms['last_page']; $page++)

                        <li class="page-item {{ $page == $allsms['current_page'] ? 'active' : '' }}">

                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $page]) }}">
                            {{ $page }}
                        </a>

                        </li>

                        @endfor

                        @if($allsms['current_page'] < $allsms['last_page'])

                            <li class="page-item">
                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $allsms['current_page'] + 1]) }}">
                                Next
                            </a>
                            </li>

                            @endif
                </ul>
            </nav>

        </div>

        @endif

    </div>

</div>

@endsection