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

                        <form action="{{route('admin.bulksms.store')}}" method="POST" autocomplete="off">
                            @csrf
                            @method('POST')

                            <!-- <input type="hidden" name="recipient_ids" id="recipientIds"> -->
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
                                <div class="mb-4"><label class="form-label fw-semibold d-block mb-2">Enter Phone Number</label>
                                    <div class="col-md-6">
                                        <div class="input-group"><span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                        <input type="tel" class="form-control" name="phone_number" placeholder="Enter phone number"></div>
                                        <small class="text-body-secondary mt-1 d-block">Enter the recipient's phone number</small>
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

                                        <label class="form-label fw-semibold mb-0">Message</label>

                                        <div class="btn-group btn-group-sm" role="group">

                                            <input type="radio" class="btn-check" name="language" id="languageEnglish" value="English" checked>
                                            <label class="btn btn-outline-primary" for="languageEnglish">English<span class="opacity-75">· 160/SMS</span></label>

                                            <input type="radio" class="btn-check" name="language" id="languageBangla" value="Bangla">
                                            <label class="btn btn-outline-secondary" for="languageBangla"> বাংলা <span class="opacity-75">· 67/SMS</span></label>

                                        </div>

                                    </div>

                                    <div class="border rounded-3 overflow-hidden">

                                        <textarea id="customSMS" name="custom_sms" class="form-control border-0 rounded-0 shadow-none" rows="7"
                                            placeholder="Type your SMS message here..."></textarea>

                                        <div class="bg-light border-top px-3 py-2">

                                            <div class="d-flex justify-content-between align-items-center">
                                                <span id="smsCharCountBs" class="small text-body-secondary">0 characters</span>
                                                <span id="smsCountBadgeBs" class="badge bg-white text-body-secondary border">0 SMS / recipient</span>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Sending -->
                                <!-- <div class="mb-4">

                                    <label class="form-label fw-semibold mb-2"> Sending Options </label>

                                    <div class="row g-3">

                                        <div class="col-md-5">
                                            <select class="form-select" name="sending_method">
                                                <option value="send_now">Send now</option>
                                                <option value="scheduled_message">Schedule for later</option>
                                            </select>
                                        </div>

                                        <div class="col-md-7">

                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i class="bi bi-calendar-event"></i></span>
                                                <input type="text" name="schedule_time" class="form-control" id="datepicker" placeholder="Select date & time">
                                            </div>

                                        </div>

                                    </div>

                                </div> -->

                                <!-- Action -->
                                <div class="border-top pt-4">

                                    <button type="submit" class="btn btn-primary btn-lg w-100 text-center">
                                        <i class="bi bi-send me-2"></i>Send Message
                                    </button>

                                    <div class="justify-content-center text-center mt-2">
                                        <small class="text-center">
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

                    <!-- Recipients -->
                    <div class="card mb-3">

                        <div class="card-head">
                            <div>
                                <h3>Recipients</h3>
                                <span class="hint" id="recipientSummaryBs">0 selected</span>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="selectAllRecipients">
                                    Select All
                                </button>

                                <button type="button" class="btn btn-sm btn-outline-secondary" id="clearAllRecipients">
                                    Clear All
                                </button>
                            </div>
                        </div>

                        <div class="p-3">

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

                            <!-- Recipient Search -->
                            <div class="position-relative">

                                <input type="text"
                                    class="form-control"
                                    id="recipientSearch"
                                    placeholder="Search name, phone or UID..."
                                    autocomplete="off">

                                <!-- Dropdown -->
                                <div id="recipientDropdown"
                                    class="position-absolute bg-white border rounded-3 shadow-sm w-100 mt-1 d-none"
                                    style="z-index: 1050; max-height: 300px; overflow-y: auto;">

                                    @foreach($members as $member)

                                    <div class="recipient-option px-3 py-2 border-bottom"
                                        data-name="{{ strtolower($member->name) }}"
                                        data-phone="{{ $member->phone }}"
                                        data-uid="{{ strtolower($member->unique_id) }}"
                                        data-id="{{ $member->id }}">

                                        <div class="d-flex align-items-center gap-2">

                                            <input type="checkbox"
                                                class="recipient-checkbox"
                                                name="recipients[]"
                                                value="{{ $member->id }}"
                                                id="recipient{{ $member->id }}"
                                                data-name="{{ $member->name }}"
                                                data-phone="{{ $member->phone }}"
                                                data-uid="{{ $member->unique_id }}">

                                            <label class="flex-grow-1 mb-0"
                                                for="recipient{{ $member->id }}"
                                                style="cursor:pointer;">

                                                <div class="fw-semibold">
                                                    {{ $member->name }}
                                                </div>

                                                <div class="small text-body-secondary">
                                                    {{ $member->phone }}
                                                    <span class="mx-1">·</span>
                                                    {{ $member->unique_id }}
                                                </div>

                                            </label>

                                        </div>

                                    </div>

                                    @endforeach

                                </div>

                            </div>

                            <div class="hint mt-2">
                                <span id="selectedRecipientHint">0</span> residents selected ·
                                <span id="validRecipientHint">0</span> valid mobile numbers
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
            '#recipientDropdown .recipient-checkbox:checked'
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
    const recipientDropdown = document.getElementById('recipientDropdown');
    const recipientOptions = document.querySelectorAll('.recipient-option');


    /*
     * Show dropdown when search box is focused
     */
    recipientSearch.addEventListener('focus', function() {
        recipientDropdown.classList.remove('d-none');
        filterRecipients();
    });


    /*
     * Live search
     */
    recipientSearch.addEventListener('input', function() {
        recipientDropdown.classList.remove('d-none');
        filterRecipients();
    });


    function filterRecipients() {

        let search = recipientSearch.value.toLowerCase().trim();
        let visibleCount = 0;

        recipientOptions.forEach(function(option) {

            let name = option.dataset.name;
            let phone = option.dataset.phone;
            let uid = option.dataset.uid;

            if (
                name.includes(search) ||
                phone.includes(search) ||
                uid.includes(search)
            ) {
                option.classList.remove('d-none');
                visibleCount++;
            } else {
                option.classList.add('d-none');
            }

        });

        if (visibleCount === 0) {
            recipientDropdown.classList.add('d-none');
        }
    }


    /*
     * Select / remove individual recipient
     */
    document.querySelectorAll('.recipient-checkbox').forEach(function(checkbox) {

        checkbox.addEventListener('change', function() {
            updateRecipients();
        });

    });


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

        selectedContainer.innerHTML = '';

        if (selected.length === 0) {

            let emptyText = document.createElement('span');

            emptyText.id = 'noRecipientText';
            emptyText.className =
                'text-body-secondary small align-self-center';

            emptyText.textContent = 'No recipients selected';

            selectedContainer.appendChild(emptyText);

        } else {

            selected.forEach(function(checkbox) {

                let badge = document.createElement('span');

                badge.className =
                    'badge bg-primary-subtle text-primary border d-flex align-items-center gap-1';

                badge.innerHTML =
                    checkbox.dataset.name +
                    ' <button type="button" class="btn-close btn-close-sm" aria-label="Remove"></button>';

                badge.querySelector('button').addEventListener('click', function() {

                    checkbox.checked = false;

                    updateRecipients();
                });

                selectedContainer.appendChild(badge);
            });
        }

        let recipientCount = selected.length;

        document.getElementById('recipientSummaryBs').textContent =
            recipientCount + ' selected';

        document.getElementById('selectedRecipientHint').textContent =
            recipientCount;

        document.getElementById('validRecipientHint').textContent =
            recipientCount;

        updateSmsCount();
    }


    /*
     * Select All
     */
    document.getElementById('selectAllRecipients')
        .addEventListener('click', function() {

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

            document.querySelectorAll('.recipient-checkbox')
                .forEach(function(checkbox) {
                    checkbox.checked = false;
                });

            updateRecipients();
        });


    /*
     * Close dropdown when clicking outside
     */
    document.addEventListener('click', function(event) {

        if (
            !recipientSearch.contains(event.target) &&
            !recipientDropdown.contains(event.target)
        ) {
            recipientDropdown.classList.add('d-none');
        }

    });


    /*
     * Initial state
     */
    updateRecipients();
</script>
@endpush