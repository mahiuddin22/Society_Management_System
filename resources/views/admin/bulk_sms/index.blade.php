@extends('admin.layouts.app')
@section('content')
@push('styles')
<style>
    .loading-dots {
        display: inline-flex;
        gap: 4px;
        align-items: center;
    }

    .loading-dots i {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        animation: loadingDots 1.2s infinite ease-in-out;
    }

    .loading-dots i:nth-child(2) {
        animation-delay: .15s;
    }

    .loading-dots i:nth-child(3) {
        animation-delay: .3s;
    }

    .recipient-type-card {
        min-height: 88px;
        background-color: var(--bs-body-bg);
        transition: background-color .15s ease;
    }

    .btn-check:focus-visible+.recipient-type-card {
        outline: 3px solid rgba(var(--bs-primary-rgb), .25);
        outline-offset: 2px;
    }

    .btn-check:checked+.recipient-type-card {
        background-color: var(--bs-primary-bg-subtle);
    }

    .recipient-type-card .recipient-type-icon {
        background-color: var(--bs-tertiary-bg);
        color: var(--bs-secondary-color);
    }

    .btn-check:checked+.recipient-type-card .recipient-type-icon {
        background-color: var(--bs-primary) !important;
        color: #fff !important;
    }

    @keyframes loadingDots {

        0%,
        80%,
        100% {
            opacity: .3;
            transform: scale(.7);
        }

        40% {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
@endpush
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
                <div class="value" id="totalSent">
                    <div class="value" id="totalSent"><span class="loading-dots"><i></i><i></i><i></i></span></div>
                </div>
                <div class="delta up">▲ Total sms sent in this {{ now()->format('F') }}</div>
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
                                    <h5 class="mb-1 fw-semibold">New Message</h5>
                                    <small class="text-body-secondary">Create and send a message</small>
                                </div>

                                <span class="badge rounded-pill bg-light text-success border px-3 py-2">
                                    <i class="bi bi-cloud-check me-1"></i> Draft autosaved
                                </span>
                            </div>
                        </div>

                        <form id="bulkSmsForm" action="{{route('admin.bulksms.store')}}" method="POST" autocomplete="off">
                            @csrf
                            @method('POST')

                            <input type="hidden" name="recipient_ids" id="recipientIds">

                            <div class="card-body p-4">

                                <!-- Recipient Type -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold mb-2">Recipient Type</label>

                                    <div class="row g-2">


                                        <div class="col-md-6">
                                            <input type="radio" class="btn-check" name="member_type" id="customMember" form="bulkSmsForm" value="custom_member">

                                            <label for="customMember" class="recipient-type-card border rounded-3 p-3 w-100 d-flex align-items-center gap-3" style="cursor:pointer;">

                                                <div class="recipient-type-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:44px;height:44px;">
                                                    <i class="bi bi-person-plus fs-5"></i>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold">Custom Member</div>
                                                    <small class="text-body-secondary">
                                                        Send directly to a phone number
                                                    </small>
                                                </div>

                                            </label>
                                        </div>

                                        <div class="col-md-6">
                                            <input type="radio" class="btn-check" name="member_type" id="existingMember" form="bulkSmsForm" value="existing_member" checked>

                                            <label for="existingMember" class="recipient-type-card border rounded-3 p-3 w-100 d-flex align-items-center gap-3" style="cursor:pointer;">

                                                <div class="recipient-type-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                    style="width:44px;height:44px;"> <i class="bi bi-people fs-5"></i>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold">Existing Recipients</div>
                                                    <small class="text-body-secondary"> Select recipients from your member list </small>
                                                </div>

                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <!-- Message Source -->
                                <div class="mb-4">

                                    <label class="form-label fw-semibold d-block mb-2">
                                        Message Source
                                    </label>

                                    <div class="row g-2">

                                        <div class="col-md-6">
                                            <input type="radio" class="btn-check" name="sms_type" id="customSmsType" value="custom" checked onclick="customSms()">

                                            <label for="customSmsType" class="recipient-type-card border rounded-3 p-3 w-100 d-flex align-items-center gap-3" style="cursor:pointer;">

                                                <div class="recipient-type-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;">
                                                    <i class="bi bi-pencil-square"></i>
                                                </div>

                                                <div>
                                                    <div class="fw-semibold">Custom Message</div>
                                                    <small class="text-body-secondary">Write a new message</small>
                                                </div>

                                            </label>
                                        </div>

                                        <div class="col-md-6">
                                            <input type="radio" class="btn-check" name="sms_type" id="draftSmsType" value="draft" onclick="draftSms()">

                                            <label for="draftSmsType"
                                                class="recipient-type-card border rounded-3 p-3 w-100 d-flex align-items-center gap-3" style="cursor:pointer;">

                                                <div class="recipient-type-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                </div>

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

                                    <select class="form-select" name="draft_id" id="draftSMS">
                                        <option value="">Start from a draft…</option>
                                        @foreach ($drafts as $draft)
                                        <option value="{{$draft->id}}">{{$draft->type}}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <!-- Message -->
                                <div class="mb-4" id="CustomSmsArea">

                                    <div class="d-flex justify-content-between align-items-center mb-2">

                                        <label class="form-label fw-semibold mb-0">
                                            Message
                                        </label>

                                        <div class="btn-group btn-group-sm" role="group">

                                            <input type="radio" class="btn-check" name="language" id="languageEnglish" value="English" checked>

                                            <label class="btn btn-outline-primary" for="languageEnglish">
                                                English <span class="opacity-75">· 160/SMS</span>
                                            </label>

                                            <input type="radio"
                                                class="btn-check" name="language" id="languageBangla" value="Bangla">

                                            <label class="btn btn-outline-secondary" for="languageBangla">
                                                বাংলা <span class="opacity-75">· 67/SMS</span>
                                            </label>

                                        </div>

                                    </div>

                                    <div class="border rounded-3 overflow-hidden">

                                        <textarea id="customSMS" name="custom_sms"
                                            class="form-control border-0 rounded-0 shadow-none" rows="7"
                                            placeholder="Type your SMS message here..."></textarea>

                                        <div class="bg-light border-top px-3 py-2">

                                            <div class="d-flex justify-content-between align-items-center">

                                                <span id="smsCharCountBs"
                                                    class="small text-body-secondary"> 0 characters
                                                </span>

                                                <span id="smsCountBadgeBs"
                                                    class="badge bg-white text-body-secondary border">
                                                    0 SMS / recipient
                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Action -->
                                <div class="border-top pt-4">

                                    <button type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-send me-2"></i> <span>Send Message</span>
                                    </button>

                                    <div class="text-center mt-2">
                                        <small class="text-body-secondary">
                                            You can review recipients and message details before sending.
                                        </small>
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>

                </div>

                <!-- Recipients + Cost -->
                <div class="col-lg-5">


                    <!-- Estimated Cost -->
                    <div class="card mb-4">

                        <div class="card-head">
                            <h3>Estimated Cost</h3>
                        </div>

                        <div class="table-wrap">

                            <table class="ledger text-nowrap">
                                <tbody>

                                    <tr>
                                        <td>Recipients selected</td>
                                        <td class="text-end" id="smsRecipientCountBs">0</td>
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
                                        <td class="text-end" id="smsRateBs">
                                            ৳{{ round($amount/0.35, 2) }} / SMS
                                        </td>
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

                    <!-- Recipient -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-3">

                            <!-- Custom Member -->
                            <div id="customMemberArea">

                                <label class="form-label fw-semibold mb-2">Phone Number</label>

                                <div class="w-100">

                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-telephone"></i>
                                        </span>

                                        <input type="tel" class="form-control" name="target_recipient" id="targetRecipient" form="bulkSmsForm" placeholder="Enter recipient phone number">

                                    </div>

                                    <small class="text-body-secondary d-block mt-1">
                                        Enter the recipient's phone number with or without country code.
                                    </small>

                                </div>
                            </div>

                        </div>

                        <!-- Existing Member -->
                        <div id="existingMemberArea" style="display:none;">

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-semibold mb-0">Select Recipients</label>

                                <span class="badge bg-light text-dark border">
                                    <span id="recipientSummaryBs">0 selected</span>
                                </span>
                            </div>

                            <div class="border rounded-3 p-3">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-body-secondary">
                                        Select members who should receive this message.
                                    </small>

                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="selectAllRecipients">
                                            <i class="bi bi-check2-all me-1"></i>Select All
                                        </button>

                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="clearAllRecipients">
                                            <i class="bi bi-x-lg me-1"></i>Clear
                                        </button>
                                    </div>
                                </div>
                                <!-- Selected Recipients -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Selected Recipients
                                    </label>

                                    <div id="selectedRecipients"
                                        class="border rounded-3 p-2 d-flex flex-wrap gap-2"
                                        style="min-height: 48px;">

                                        <span id="noRecipientText"
                                            class="text-body-secondary small align-self-center">
                                            No recipients selected
                                        </span>

                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-search"></i>
                                        </span>

                                        <input type="search" class="form-control" id="recipientSearch" placeholder="Search name, phone or UID...">
                                    </div>
                                </div>

                                <div id="recipientList" class="border rounded-3 overflow-auto" style="max-height:280px;">

                                    @foreach($members as $member)
                                    <label class="recipient-item d-flex align-items-center gap-3 px-3 py-2 border-bottom mb-0"
                                        style="cursor:pointer;">

                                        <input type="checkbox" class="form-check-input recipient-checkbox flex-shrink-0" name="recipients[]" value="{{$member->id}}" data-name="{{ $member->name }}" form="bulkSmsForm">

                                        <div class="flex-grow-1">
                                            <div class="fw-semibold recipient-name">
                                                {{$member->name}}
                                            </div>

                                            <small class="text-body-secondary">
                                                {{$member->phone}} · {{$member->unique_id}}
                                            </small>
                                        </div>

                                        <i class="bi bi-check-circle-fill text-primary d-none"></i>

                                    </label>
                                    @endforeach

                                </div>

                                <div class="mt-2">
                                    <small class="text-body-secondary">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Only selected members with valid mobile numbers will receive the message.
                                    </small>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

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

<!-- Datetime Picker Scripts -->
<script>
    $(document).ready(function() {
        flatpickr('#datepicker', {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            minDate: 'today',
            time_24hr: true,
            minuteIncrement: 5,
            disableMobile: true
        });
    });
</script>

<!-- Fetching Data Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        fetch('http://103.230.63.50/bulksms/api/sent-sms-this-month')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalSent').textContent = data.this_month ?? 0;
            })
            .catch(error => {
                document.getElementById('totalSent').textContent = '0';
                console.error(error);
            });

    });
</script>

<!-- Tab Changeing Scripts -->
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
    let smsRate = 0.35;

    function customSms() {
        document.getElementById('CustomSmsArea').style.display = 'block';
        document.getElementById('customSMS').required = true;

        document.getElementById('draftSmsBox').style.display = 'none';
        document.getElementById('draftSMS').required = false;

        updateSmsCount();
    }

    function draftSms() {
        document.getElementById('CustomSmsArea').style.display = 'none';
        document.getElementById('customSMS').required = false;

        document.getElementById('draftSmsBox').style.display = 'block';
        document.getElementById('draftSMS').required = true;

        updateSmsCount();
    }

    function getRecipientCount() {
        return document.querySelectorAll(
            '.recipient-checkbox:checked'
        ).length;
    }

    function updateSmsCount() {

        let message = document.getElementById('customSMS').value;
        let characterCount = message.length;

        let smsPerRecipient = characterCount > 0 ?
            Math.ceil(characterCount / smsLimit) :
            0;

        let recipientCount = getRecipientCount();

        let totalSms = smsPerRecipient * recipientCount;

        let totalCost = totalSms * smsRate;

        document.getElementById('smsCharCountBs').textContent =
            characterCount + ' characters';

        document.getElementById('smsCountBadgeBs').textContent =
            smsPerRecipient + ' SMS / recipient';

        document.getElementById('smsRecipientCountBs').textContent =
            recipientCount;

        document.getElementById('smsPerRecipientBs').textContent =
            smsPerRecipient;

        document.getElementById('smsTotalCountBs').textContent =
            totalSms;

        document.getElementById('smsRateBs').textContent =
            '৳' + smsRate.toFixed(2) + ' / SMS';

        document.getElementById('smsTotalCostBs').textContent =
            '৳' + totalCost.toFixed(2);
    }

    document.getElementById('customSMS').addEventListener('input', function() {
        updateSmsCount();
    });

    document.querySelectorAll('input[name="language"]').forEach(function(radio) {

        radio.addEventListener('change', function() {

            if (this.value === 'Bangla') {
                smsLimit = 67;
            } else {
                smsLimit = 160;
            }

            updateSmsCount();
        });

    });

    document.querySelectorAll('.ledger input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            updateSmsCount();
        });
    });

    updateSmsCount();
</script>

<!-- Recipient and SMS count Script -->
<script>
    const recipientSearch = document.getElementById('recipientSearch');
    const recipientOptions = document.querySelectorAll('#recipientList .recipient-item');


    /*
     * Live search
     */
    function filterRecipients() {
        const search = recipientSearch.value.toLowerCase().trim();

        recipientOptions.forEach(function(option) {
            option.classList.toggle(
                'd-none',
                !option.textContent.toLowerCase().includes(search)
            );
        });
    }

    recipientSearch.addEventListener('input', filterRecipients);


    /*
     * Select / remove individual recipient
     */
    document.querySelectorAll('.recipient-checkbox').forEach(function(checkbox) {

        checkbox.addEventListener('change', function() {
            updateRecipients();
        });

    });


    let compactRecipientSelection = false;

    /*
     * Update selected recipients
     */
    function updateRecipients() {

        let selected = document.querySelectorAll(
            '.recipient-checkbox:checked'
        );

        let recipientIds = Array.from(selected).map(function(checkbox) {
            return checkbox.value;
        });

        document.getElementById('recipientIds').value =
            JSON.stringify(recipientIds);

        let selectedContainer =
            document.getElementById('selectedRecipients');
        let recipientCount = selected.length;

        selectedContainer.innerHTML = '';

        if (selected.length === 0) {

            let emptyText = document.createElement('span');

            emptyText.id = 'noRecipientText';
            emptyText.className =
                'text-body-secondary small align-self-center';

            emptyText.textContent = 'No recipients selected';

            selectedContainer.appendChild(emptyText);

        } else if (compactRecipientSelection) {

            let selectedCount = document.createElement('span');
            selectedCount.className = 'text-body-secondary small align-self-center';
            selectedCount.textContent = recipientCount + (recipientCount === 1 ? ' recipient selected' : ' recipients selected');
            selectedContainer.appendChild(selectedCount);

        } else {

            selected.forEach(function(checkbox) {

                let badge = document.createElement('span');

                badge.className =
                    'badge bg-primary-subtle text-primary border d-flex align-items-center gap-1';

                badge.appendChild(document.createTextNode(checkbox.dataset.name || 'Unnamed recipient'));

                let removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn-close btn-close-sm';
                removeButton.setAttribute('aria-label', 'Remove');
                badge.appendChild(removeButton);

                removeButton.addEventListener('click', function() {

                    checkbox.checked = false;

                    updateRecipients();
                });

                selectedContainer.appendChild(badge);
            });
        }

        document.getElementById('recipientSummaryBs').textContent =
            recipientCount + ' selected';

        updateSmsCount();
    }


    /*
     * Select All
     */
    document.getElementById('selectAllRecipients')
        .addEventListener('click', function() {

            compactRecipientSelection = true;

            document.querySelectorAll('.recipient-checkbox')
                .forEach(function(checkbox) {
                    checkbox.checked = true;
                });

            updateRecipients();
        });


    /*
     * Clear All
     */
    document.getElementById('clearAllRecipients')
        .addEventListener('click', function() {

            compactRecipientSelection = false;

            document.querySelectorAll('.recipient-checkbox')
                .forEach(function(checkbox) {
                    checkbox.checked = false;
                });

            updateRecipients();
        });


    /*
     * Initial state
     */
    updateRecipients();
</script>

<!-- Custom Member Selection Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const existingMember = document.getElementById('existingMember');
        const customMember = document.getElementById('customMember');

        const existingMemberArea = document.getElementById('existingMemberArea');
        const customMemberArea = document.getElementById('customMemberArea');

        function updateMemberType() {

            if (existingMember.checked) {
                existingMemberArea.style.display = 'block';
                customMemberArea.style.display = 'none';
            } else {
                existingMemberArea.style.display = 'none';
                customMemberArea.style.display = 'block';
            }
        }

        existingMember.addEventListener('change', updateMemberType);
        customMember.addEventListener('change', updateMemberType);

        updateMemberType();

    });
</script>
@endpush
