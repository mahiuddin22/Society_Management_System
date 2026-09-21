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
                <button type="button" class="btn btn-primary btn-sm sms-recharge-btn">Recharge Balance</button>
            </div>
        </div>


    </div>

    <!-- SMS Tabs -->

    <div class="filter-bar">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button type="button" class="btn btn-primary sms-tab-btn active" data-sms-tab="smsCompose">Compose Campaign</button>
            <button type="button" class="btn btn-secondary sms-tab-btn" data-sms-tab="smsDrafts">Drafts</button>
            <button type="button" class="btn btn-secondary sms-tab-btn" data-sms-tab="smsReports">Delivery Reports</button>
            <button type="button" class="btn btn-secondary sms-tab-btn" data-sms-tab="smsRecharge">Recharge & Settings</button>
        </div>
    </div>

    <div class="sms-tab-content">

        <!-- COMPOSE CAMPAIGN -->
        <div id="smsCompose" class="sms-tab-pane active">

            <div class="row g-3">

                <!-- New Campaign -->
                <div class="col-lg-7">

                    <div class="card border-0 shadow-sm overflow-hidden">

                        <!-- Header -->
                        <div class="card-header bg-white border-bottom px-4 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1 fw-semibold">New Campaign</h5>
                                    <small class="text-body-secondary">Create and send a personalized SMS campaign</small>
                                </div>

                                <span class="badge rounded-pill bg-light text-success border px-3 py-2">
                                    <i class="bi bi-cloud-check me-1"></i> Draft autosaved
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            
                            <!-- SMS Type -->
                            <div class="mb-4">

                                <label class="form-label fw-semibold d-block mb-2">Message Source</label>

                                <div class="row g-2">

                                    <div class="col-md-6">
                                        <label class="border rounded-3 p-3 w-100 h-100 d-flex align-items-center gap-3" style="cursor:pointer;">
                                            <input type="radio" class="form-check-input mt-0" name="sms_type" value="custom" checked onclick="customSms()">
                                            <div>
                                                <div class="fw-semibold">Custom Message</div>
                                                <small class="text-body-secondary">Write a new message</small>
                                            </div>

                                        </label>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="border rounded-3 p-3 w-100 h-100 d-flex align-items-center gap-3" style="cursor:pointer;">
                                            <input type="radio" class="form-check-input mt-0" name="sms_type" value="draft" onclick="draftSms()">
                                            <div>
                                                <div class="fw-semibold">Draft Message</div>
                                                <small class="text-body-secondary">Use an existing draft</small>
                                            </div>
                                        </label>
                                    </div>

                                </div>

                            </div>

                            <!-- Draft -->
                            <div class="mb-4" id="draftSmsBox" style="display:none;">

                                <label class="form-label fw-semibold">Start From Draft</label>
                                <select class="form-select" id="draftSMS">
                                    <option value="">Start from a draft…</option>
                                    <option value="Monthly Invoice Notice">Monthly Invoice Notice</option>
                                    <option value="Payment Reminder">Payment Reminder</option>
                                    <option value="Event Invitation">Event Invitation</option>
                                </select>

                            </div>

                            <!-- Message -->
                            <div class="mb-4">

                                <div class="d-flex justify-content-between align-items-center mb-2">

                                    <label class="form-label fw-semibold mb-0">
                                        Message
                                    </label>

                                    <div class="btn-group btn-group-sm">

                                        <button type="button" class="btn btn-primary active" data-lang="en">English
                                            <span class="opacity-75">· 160/SMS</span>
                                        </button>

                                        <button type="button" class="btn btn-outline-secondary" data-lang="bn"> বাংলা
                                            <span class="opacity-75">· 67/SMS</span>
                                        </button>

                                    </div>

                                </div>

                                <div class="border rounded-3 overflow-hidden">

                                    <textarea id="customSMS" class="form-control border-0 rounded-0 shadow-none" rows="7"
                                        placeholder="Type your SMS message here..." required></textarea>

                                    <div class="bg-light border-top px-3 py-2">

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span id="smsCharCountBs" class="small text-body-secondary">0 characters</span>
                                            <span id="smsCountBadgeBs" class="badge bg-white text-body-secondary border">0 SMS / recipient</span>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Sending -->
                            <div class="mb-4">

                                <label class="form-label fw-semibold mb-2"> Sending Options </label>

                                <div class="row g-3">

                                    <div class="col-md-5">
                                        <select class="form-select">
                                            <option>Send now</option>
                                            <option>Schedule for later</option>
                                        </select>
                                    </div>

                                    <div class="col-md-7">

                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-calendar-event"></i>
                                            </span>
                                            <input type="datetime-local" class="form-control">
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Action -->
                            <div class="border-top pt-4">

                                <button type="button" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-send me-2"></i>Review & Send Campaign
                                </button>

                                <div class="text-center mt-2">
                                    <small class="text-body-secondary">
                                        You can review recipients and message details before sending.
                                    </small>
                                </div>

                            </div>

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
                                <button type="button" class="btn btn-secondary">Single</button>
                                <button type="button" class="btn btn-secondary">Multiple</button>
                                <button type="button" class="btn btn-primary">All Residents</button>
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
        <div id="smsDrafts" class="sms-tab-pane d-none">

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
        <div id="smsReports" class="sms-tab-pane d-none">

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
        <div id="smsRecharge" class="sms-tab-pane d-none">

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
                                <button type="button" class="btn btn-secondary btn-sm quick-amount" data-amount="500">৳500</button>
                                <button type="button" class="btn btn-secondary btn-sm quick-amount" data-amount="1000">৳1,000</button>
                                <button type="button" class="btn btn-primary btn-sm quick-amount" data-amount="2500">৳2,500</button>
                                <button type="button" class="btn btn-secondary btn-sm quick-amount" data-amount="5000">৳5,000</button>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Custom Amount</label>
                                <input type="number" id="customAmount" class="form-control" placeholder="Custom amount (৳)">
                            </div>

                            <div class="hint mb-3">
                                ≈ 5,000 SMS at ৳0.50 / SMS with the selected amount
                            </div>

                            <button class="btn btn-primary w-100">
                                Recharge Now
                            </button>

                        </div>

                        <script>
                            document.querySelectorAll('.quick-amount').forEach(function(button) {
                                button.addEventListener('click', function() {

                                    document.getElementById('customAmount').value = this.dataset.amount;

                                    document.querySelectorAll('.quick-amount').forEach(function(btn) {
                                        btn.classList.remove('btn-primary');
                                        btn.classList.add('btn-secondary');
                                    });

                                    this.classList.remove('btn-secondary');
                                    this.classList.add('btn-primary');
                                });
                            });
                        </script>

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
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const tabButtons = document.querySelectorAll('.sms-tab-btn');
        const tabPanes = document.querySelectorAll('.sms-tab-pane');

        function showSmsTab(targetId) {

            tabButtons.forEach(function(btn) {
                btn.classList.remove('active', 'btn-primary');
                btn.classList.add('btn-secondary');
            });

            tabPanes.forEach(function(pane) {
                pane.classList.add('d-none');
                pane.classList.remove('active');
            });

            const button = document.querySelector('[data-sms-tab="' + targetId + '"]');
            const pane = document.getElementById(targetId);

            if (button) {
                button.classList.remove('btn-secondary');
                button.classList.add('active', 'btn-primary');
            }

            if (pane) {
                pane.classList.remove('d-none');
                pane.classList.add('active');
            }
        }

        tabButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                showSmsTab(this.getAttribute('data-sms-tab'));
            });
        });

        const rechargeButton = document.querySelector('.sms-recharge-btn');

        if (rechargeButton) {
            rechargeButton.addEventListener('click', function() {
                showSmsTab('smsRecharge');
            });
        }

    });
</script>

<!-- Hide Show SMS Types -->
<script>
    let smsLimit = 160;

    function customSms() {
        document.getElementById('customSMS').style.display = 'block';
        document.getElementById('customSMS').required = true;

        document.getElementById('draftSmsBox').style.display = 'none';
        document.getElementById('draftSMS').required = false;
    }

    function draftSms() {
        document.getElementById('customSMS').style.display = 'none';
        document.getElementById('customSMS').required = false;

        document.getElementById('draftSmsBox').style.display = 'block';
        document.getElementById('draftSMS').required = true;
    }

    function updateSmsCount() {
        let message = document.getElementById('customSMS').value;
        let characterCount = message.length;
        let smsCount = characterCount > 0 ? Math.ceil(characterCount / smsLimit) : 0;

        document.getElementById('smsCharCountBs').textContent = characterCount + ' characters';
        document.getElementById('smsCountBadgeBs').textContent = smsCount + ' SMS / recipient';
    }

    document.getElementById('customSMS').addEventListener('input', function() {
        updateSmsCount();
    });

    document.querySelectorAll('[data-lang]').forEach(function(button) {
        button.addEventListener('click', function() {

            document.querySelectorAll('[data-lang]').forEach(function(btn) {
                btn.classList.remove('btn-primary', 'active');
                btn.classList.add('btn-outline-secondary');
            });

            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-primary', 'active');

            if (this.dataset.lang === 'bn') {
                smsLimit = 67;
            } else {
                smsLimit = 160;
            }

            updateSmsCount();
        });
    });

    updateSmsCount();
</script>
@endpush