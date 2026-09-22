@extends('admin.layouts.app')

@section('content')

<div class="card mb-3">


    <div class="card-head">
        <h3>Campaign History</h3>
        <span class="hint">SMS delivery summary</span>
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
                @foreach($allsms['data'] as $item)
                <tr>
                    <td>{{ $item['mobile_no'] }}</td>
                    <td>{{ $item['message'] }}</td>
                    <td>{{ strlen($item['message']) }} chars</td>
                    <td>
                        <span class="badge {{$item['api_status'] == 3 ? 'green' : 'red'}}">{{ $item['api_status'] == 3 ? 'Sent' : 'Canceled' }}</span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($item['attempt_time']) }} <br>
                        <strong>{{ \Carbon\Carbon::parse($item['attempt_time'])->diffForHumans() }}</strong>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <!-- Pagination -->
        @if($allsms['last_page'] > 1)

        <div class="mt-3 d-flex justify-content-end">
            <nav>
                <ul class="pagination">

                    @if($allsms['current_page'] > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ url()->current() }}?page={{ $allsms['current_page'] - 1 }}">Previous</a>
                    </li>
                    @endif

                    @for($page = 1; $page <= $allsms['last_page']; $page++)
                    <li class="page-item {{ $page == $allsms['current_page'] ? 'active' : '' }}">
                        <a class="page-link" href="{{ url()->current() }}?page={{ $page }}">{{ $page }}</a>
                    </li>
                    @endfor

                    @if($allsms['current_page'] < $allsms['last_page'])
                    <li class="page-item">
                        <a class="page-link" href="{{ url()->current() }}?page={{ $allsms['current_page'] + 1 }}">Next</a>
                    </li>
                    @endif

                </ul>
            </nav>
        </div>
        @endif

    </div>


</div>

<!-- Delivery Log -->

<div class="card">


    <div class="card-head">
        <h3>July Invoice Notice — Delivery Log</h3>
        <span class="hint">148 recipients</span>
    </div>

    <div class="table-wrap">

        <table class="ledger text-nowrap">

            <thead>
                <tr>
                    <th>Resident</th>
                    <th>Unit</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Delivered At</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>Kamal Hossain</td>
                    <td>A-04B</td>
                    <td>01711-223344</td>
                    <td>
                        <span class="badge badge-paid">Delivered</span>
                    </td>
                    <td>10:02 AM</td>
                </tr>

                <tr>
                    <td>Fahmida Begum</td>
                    <td>A-01A</td>
                    <td>01822-556677</td>
                    <td>
                        <span class="badge badge-paid">Delivered</span>
                    </td>
                    <td>10:02 AM</td>
                </tr>

                <tr>
                    <td>Shahidul Islam</td>
                    <td>B-06C</td>
                    <td>01933-889900</td>
                    <td>
                        <span class="badge badge-due">Failed</span>
                    </td>
                    <td>—</td>
                </tr>

                <tr>
                    <td>Delwar Hossain</td>
                    <td>D-03B</td>
                    <td>01655-112233</td>
                    <td>
                        <span class="badge badge-partial">Pending</span>
                    </td>
                    <td>—</td>
                </tr>

            </tbody>

        </table>

    </div>


</div>

@endsection