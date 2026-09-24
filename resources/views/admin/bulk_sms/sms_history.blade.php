@extends('admin.layouts.app')

@section('content')
<div class="p-3 border-bottom">
    <form action="{{ url()->current() }}" method="GET">

        <div class="row g-2">

            <div class="col-md-3">
                <label class="form-label">Mobile No</label>
                <input type="text" name="mobile_no" class="form-control" value="{{ request('mobile_no') }}" placeholder="Mobile number">
            </div>

            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="api_status" class="form-select">
                    <option value="">All Status</option>
                    <option value="3" {{ request('api_status') == '3' ? 'selected' : '' }}>Sent</option>
                    <option value="0" {{ request('api_status') == '0' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
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
    </div>


    <div class="table-wrap">

        <table class="ledger text-nowrap">

            <thead>
                <tr>
                    <th>Mobile No</th>
                    <th>Message</th>
                    <th>Character Count</th>
                    <th>Status</th>
                    <th>Request Time</th>
                </tr>
            </thead>

            <tbody>

                @forelse($allsms['data'] ?? [] as $item)

                <tr>

                    <td>{{ $item['mobile_no'] }}</td>

                    <td>{{ $item['message'] }}</td>

                    <td>{{ strlen($item['message']) }} chars</td>

                    <td>
                        <span class="badge {{ $item['api_status'] == 3 ? 'green' : 'red' }}">
                            {{ $item['api_status'] == 3 ? 'Sent' : 'Canceled' }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($item['attempt_time']) }}
                        <br>
                        <strong>
                            {{ \Carbon\Carbon::parse($item['attempt_time'])->diffForHumans() }}
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