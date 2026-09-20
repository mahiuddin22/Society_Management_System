@extends('admin.layouts.app')

@section('content')

<section class="panel active" id="panel-sms">

    <!-- SMS Summary -->

    <div class="filter-bar">
        <div>
            <h3 class="mb-1">SMS Management</h3>
            <span class="hint">Manage SMS campaigns, drafts, delivery reports and balance</span>
        </div>
    </div>

    <div class="row g-3 mb-3">


        <div class="col-6 col-md-3">
            <div class="card stat-card p-3 h-100">
                <div class="label">SMS Balance</div>
                <div class="value"><span class="sym">৳</span>{{ $amount }}</div>
                <div class="delta up">Auto top-up off</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card stat-card p-3 h-100">
                <div class="label">SMS Credits Remaining</div>
                <div class="value">{{ round($amount/0.35, 2) }}</div>
                <div class="delta up">Expired in: {{ \Carbon\Carbon::parse($validity_period)->format('d-M-Y') }}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card stat-card p-3 h-100">
                <div class="label">Sent This Month</div>
                <div class="value">{{$totalsent}}</div>
                <div class="delta up">▲ Total sms sent in this {{now()->format('F')}}</div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card p-3 h-100 d-flex flex-column justify-content-center gap-2">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small fw-semibold text-body-secondary">Running low?</span>
                    <span class="badge badge-partial">Below 5,000</span>
                </div>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="tab" data-bs-target="#smsRecharge">
                    Recharge Balance
                </button>
            </div>
        </div>


    </div>

    <!-- SMS Tabs -->

    <div class="filter-bar">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button type="button" class="btn btn-primary active" data-bs-toggle="tab" data-bs-target="#smsCompose">Compose Campaign</button>
            <button type="button" class="btn btn-secondary" data-bs-toggle="tab" data-bs-target="#smsDrafts">Drafts</button>
            <button type="button" class="btn btn-secondary" data-bs-toggle="tab" data-bs-target="#smsReports">Delivery Reports</button>
            <button type="button" class="btn btn-secondary" data-bs-toggle="tab" data-bs-target="#smsRecharge">Recharge & Settings</button>
        </div>
    </div>

    <div class="tab-content">

        <!-- COMPOSE CAMPAIGN -->
        <div class="tab-pane fade show active" id="smsCompose">

            <div class="row g-3">

                <!-- New Campaign -->
                <div class="col-lg-7">

                    <div class="card">

                        <div class="card-head">
                            <h3>New Campaign</h3>
                            <span class="hint">Draft autosaved</span>
                        </div>

                        <div class="p-3">

                            <div class="mb-3">
                                <label class="form-label">Campaign Name</label>
                                <input type="text" class="form-control" placeholder="Campaign name (e.g. July Invoice Notice)">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Start From Draft</label>
                                <select class="form-select">
                                    <option>Start from a draft…</option>
                                    <option>Monthly Invoice Notice</option>
                                    <option>Payment Reminder</option>
                                    <option>Event Invitation</option>
                                </select>
                            </div>

                            <div class="mb-3">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0">Message</label>

                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-primary active" data-lang="en">
                                            English · 160/SMS
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-lang="bn">
                                            বাংলা · 67/SMS
                                        </button>
                                    </div>
                                </div>

                                <textarea id="smsBodyBs"
                                    class="form-control"
                                    rows="6"
                                    placeholder="Type your message… use to personalize"></textarea>

                                <div class="d-flex justify-content-between small mt-2">
                                    <span id="smsCharCountBs" class="text-body-secondary">
                                        0 characters
                                    </span>

                                    <span id="smsCountBadgeBs" class="badge badge-neutral">
                                        0 SMS / recipient
                                    </span>
                                </div>

                            </div>

                            <!-- Dynamic Tags -->
                            <div class="mb-3">

                                <label class="form-label">Personalization Tags</label>

                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge badge-neutral sms-tag-bs" style="cursor:pointer;" data-tag="name">
                                        name
                                    </span>

                                    <span class="badge badge-neutral sms-tag-bs" style="cursor:pointer;" data-tag="holding">
                                        holding
                                    </span>

                                    <span class="badge badge-neutral sms-tag-bs" style="cursor:pointer;" data-tag="due amount">
                                        due_amount
                                    </span>

                                    <span class="badge badge-neutral sms-tag-bs" style="cursor:pointer;" data-tag="due_date">
                                        due_date
                                    </span>
                                </div>

                            </div>

                            <!-- Schedule -->
                            <div class="row g-2 mb-3">

                                <div class="col-md-5">
                                    <label class="form-label">Sending Option</label>
                                    <select class="form-select">
                                        <option>Send now</option>
                                        <option>Schedule for later</option>
                                    </select>
                                </div>

                                <div class="col-md-7">
                                    <label class="form-label">Schedule Date & Time</label>
                                    <input type="datetime-local" class="form-control">
                                </div>

                            </div>

                            <button class="btn btn-primary w-100">
                                Review & Send Campaign
                            </button>

                        </div>

                    </div>

                </div>

                <!-- Recipients + Cost -->
                <div class="col-lg-5">

                    <!-- Recipients -->
                    <div class="card mb-3">

                        <div class="card-head">
                            <h3>Recipients</h3>
                            <span class="hint">148 selected</span>
                        </div>

                        <div class="p-3">

                            <div class="btn-group w-100 mb-3">
                                <button type="button" class="btn btn-secondary">
                                    Single
                                </button>

                                <button type="button" class="btn btn-secondary">
                                    Multiple
                                </button>

                                <button type="button" class="btn btn-primary">
                                    All Residents
                                </button>
                            </div>

                            <div class="row g-2 mb-3">

                                <div class="col-md-6">
                                    <select class="form-select">
                                        <option>All buildings</option>
                                        <option>Building A</option>
                                        <option>Building B</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <select class="form-select">
                                        <option>All statuses</option>
                                        <option>Due only</option>
                                        <option>Paid</option>
                                    </select>
                                </div>

                            </div>

                            <div class="table-wrap">

                                <table class="ledger text-nowrap">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Resident</th>
                                            <th>Unit</th>
                                            <th>Mobile</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td><input type="checkbox" checked></td>
                                            <td>Kamal Hossain</td>
                                            <td>A-04B</td>
                                            <td>01711-223344</td>
                                        </tr>

                                        <tr>
                                            <td><input type="checkbox" checked></td>
                                            <td>Fahmida Begum</td>
                                            <td>A-01A</td>
                                            <td>01822-556677</td>
                                        </tr>

                                        <tr>
                                            <td><input type="checkbox" checked></td>
                                            <td>Shahidul Islam</td>
                                            <td>B-06C</td>
                                            <td>01933-889900</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="hint mt-2">
                                148 residents selected · 148 valid mobile numbers
                            </div>

                        </div>

                    </div>

                    <!-- Estimated Cost -->
                    <div class="card">

                        <div class="card-head">
                            <h3>Estimated Cost</h3>
                        </div>

                        <div class="table-wrap">

                            <table class="ledger text-nowrap">
                                <tbody>

                                    <tr>
                                        <td>Recipients selected</td>
                                        <td class="text-end" id="smsRecipientCountBs">148</td>
                                    </tr>

                                    <tr>
                                        <td>SMS per recipient</td>
                                        <td class="text-end" id="smsPerRecipientBs">0</td>
                                    </tr>

                                    <tr>
                                        <td>Total SMS to send</td>
                                        <td class="text-end" id="smsTotalCountBs">0</td>
                                    </tr>

                                    <tr>
                                        <td>Rate</td>
                                        <td class="text-end">৳0.50 / SMS</td>
                                    </tr>

                                    <tr>
                                        <td><strong>Estimated cost</strong></td>
                                        <td class="text-end">
                                            <strong id="smsTotalCostBs">৳0.00</strong>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- DRAFTS -->
        <div class="tab-pane fade" id="smsDrafts">

            <div class="card">

                <div class="card-head">
                    <h3>Saved Drafts</h3>

                    <button class="btn btn-primary btn-sm">
                        + New Draft
                    </button>
                </div>

                <div class="table-wrap">

                    <table class="ledger text-nowrap">

                        <thead>
                            <tr>
                                <th>Purpose</th>
                                <th>Draft Name</th>
                                <th>Language</th>
                                <th>Length</th>
                                <th>Last Edited</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td><span class="badge badge-paid">Invoice</span></td>
                                <td>Monthly Invoice Notice</td>
                                <td>বাংলা</td>
                                <td>112 chars · 2 SMS</td>
                                <td>2 days ago</td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Edit</button>
                                    <button class="btn btn-primary btn-sm">Use</button>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="badge badge-partial">Reminder</span></td>
                                <td>Payment Reminder — Due</td>
                                <td>English</td>
                                <td>148 chars · 1 SMS</td>
                                <td>5 days ago</td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Edit</button>
                                    <button class="btn btn-primary btn-sm">Use</button>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="badge badge-neutral">Invitation</span></td>
                                <td>Cultural Program Invitation</td>
                                <td>বাংলা</td>
                                <td>205 chars · 4 SMS</td>
                                <td>1 week ago</td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Edit</button>
                                    <button class="btn btn-primary btn-sm">Use</button>
                                </td>
                            </tr>

                            <tr>
                                <td><span class="badge badge-neutral">Invitation</span></td>
                                <td>Medical Camp Announcement</td>
                                <td>English</td>
                                <td>165 chars · 2 SMS</td>
                                <td>2 weeks ago</td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Edit</button>
                                    <button class="btn btn-primary btn-sm">Use</button>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- DELIVERY REPORTS -->
        <div class="tab-pane fade" id="smsReports">

            <div class="card mb-3">

                <div class="card-head">
                    <h3>Campaign History</h3>
                    <span class="hint">SMS delivery summary</span>
                </div>

                <div class="table-wrap">

                    <table class="ledger text-nowrap">

                        <thead>
                            <tr>
                                <th>Campaign</th>
                                <th>Sent</th>
                                <th>Recipients</th>
                                <th>Delivered</th>
                                <th>Failed</th>
                                <th>Pending</th>
                                <th>Cost</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>July Invoice Notice</td>
                                <td>23 Jul, 10:02 AM</td>
                                <td>148</td>
                                <td>142</td>
                                <td>3</td>
                                <td>3</td>
                                <td>৳148.00</td>
                                <td>
                                    <span class="badge badge-partial">In Progress</span>
                                </td>
                            </tr>

                            <tr>
                                <td>Payment Reminder — Round 2</td>
                                <td>18 Jul, 4:30 PM</td>
                                <td>41</td>
                                <td>39</td>
                                <td>2</td>
                                <td>0</td>
                                <td>৳41.00</td>
                                <td>
                                    <span class="badge badge-paid">Completed</span>
                                </td>
                            </tr>

                            <tr>
                                <td>Annual Picnic Invitation</td>
                                <td>10 Jul, 9:15 AM</td>
                                <td>248</td>
                                <td>246</td>
                                <td>2</td>
                                <td>0</td>
                                <td>৳496.00</td>
                                <td>
                                    <span class="badge badge-paid">Completed</span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

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

        </div>

        <!-- RECHARGE & SETTINGS -->
        <div class="tab-pane fade" id="smsRecharge">

            <div class="row g-3">

                <!-- Recharge -->
                <div class="col-lg-6">

                    <div class="card h-100">

                        <div class="card-head">
                            <h3>Recharge SMS Balance</h3>
                        </div>

                        <div class="p-3">

                            <label class="form-label">Quick Amount</label>

                            <div class="d-flex gap-2 flex-wrap mb-3">

                                <button type="button" class="btn btn-secondary btn-sm">৳500</button>

                                <button type="button" class="btn btn-secondary btn-sm">৳1,000</button>

                                <button type="button" class="btn btn-primary btn-sm">৳2,500</button>

                                <button type="button" class="btn btn-secondary btn-sm">৳5,000</button>

                            </div>

                            <div class="mb-3">
                                <label class="form-label">Custom Amount</label>

                                <input class="form-control" placeholder="Custom amount (৳)">
                            </div>

                            <div class="hint mb-3">
                                ≈ 5,000 SMS at ৳0.50 / SMS with the selected amount
                            </div>

                            <button class="btn btn-primary w-100">
                                Recharge Now
                            </button>

                        </div>

                    </div>

                </div>


                <!-- Settings -->
                <div class="col-lg-6">

                    <div class="card h-100">

                        <div class="card-head">
                            <h3>Gateway & Alert Settings</h3>

                            <span class="badge badge-paid">
                                API Connected
                            </span>
                        </div>

                        <div class="p-3">

                            <div class="mb-3">
                                <label class="form-label">Sender ID</label>
                                <input class="form-control" placeholder="Sender ID" value="UTS3WELFARE">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Low Balance Alert Threshold</label>

                                <input class="form-control"
                                    placeholder="Low-balance alert threshold (SMS credits)"
                                    value="1000">
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input"
                                    type="checkbox"
                                    checked
                                    id="smsAutoReminderBs">

                                <label class="form-check-label"
                                    for="smsAutoReminderBs">
                                    Auto-send payment reminder 5 days before due date
                                </label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input"
                                    type="checkbox"
                                    checked
                                    id="smsEmailAlertBs">

                                <label class="form-check-label"
                                    for="smsEmailAlertBs">
                                    Email the EC when balance drops below threshold
                                </label>
                            </div>

                            <button class="btn btn-primary w-100">
                                Save Settings
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

</section>

<script>
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(button) {
        button.addEventListener('shown.bs.tab', function(event) {
            console.log('Tab changed:', event.target.getAttribute('data-bs-target'));
        });
    });
</script>
@endsection