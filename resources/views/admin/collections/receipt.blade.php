@extends('admin.layouts.app')

@push('styles')
<!-- Google Fonts: Courier Prime for typewriter/monospaced aesthetic -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

<style>
    * {
        box-sizing: border-box;
    }

    /* POS thermal width (80mm standard = ~300px printable width) */
    .receipt-wrapper {
        width: 100%;
        max-width: 300px;
        margin: 15px auto;
        padding: 0;
    }

    .receipt {
        width: 100%;
        background: #ffffff;
        padding: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        font-family: 'Courier Prime', 'Courier New', Courier, monospace;
    }

    /* =========================
       HEADER
    ========================== */

    .receipt-brand-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .brand-left img {
        max-height: 30px;
        max-width: 80px;
        object-fit: contain;
    }

    .brand-right h2 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: #111;
        font-family: Arial, Helvetica, sans-serif;
    }

    .receipt-main-title {
        text-align: center;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 10px 0;
    }

    /* =========================
       DASHED DIVIDERS
    ========================== */

    .dashed-line {
        border: none;
        border-top: 1px dashed #000;
        margin: 8px 0;
        width: 100%;
    }

    /* =========================
       SECTION TITLES
    ========================== */

    .section-heading {
        font-size: 12px;
        font-weight: 700;
        margin: 6px 0 4px 0;
    }

    /* =========================
       TWO-COLUMN LISTS
    ========================== */

    .info-grid {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        font-size: 11px;
    }

    .info-label {
        font-weight: 400;
        color: #000;
        text-align: left;
        padding-right: 5px;
        white-space: nowrap;
    }

    .info-value {
        font-weight: 700;
        color: #000;
        text-align: right;
        word-break: break-word;
    }

    /* ========================= STAMP & FOOTER ========================== */
    .stamp-container {
        display: flex;
        justify-content: center;
        margin: 15px 0 10px 0;
    }

    .paid-stamp {
        width: 70px;
        height: 65px;
        border: 2px dotted #000;
        border-radius: 50%;
        position: relative;
        text-align: center;
        transform: rotate(-8deg);
    }

    /* ========================= TOP CIRCULAR TEXT ========================== */
    .stamp-top {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
    }

    .stamp-top span {
        position: absolute;
        left: 50%;
        top: 3px;
        transform-origin: 0 29px;
        font-size: 6px;
        font-weight: 700;
        line-height: 1;
    }

    .stamp-top span:nth-child(1) {
        transform: rotate(-55deg);
    }

    .stamp-top span:nth-child(2) {
        transform: rotate(-40deg);
    }

    .stamp-top span:nth-child(3) {
        transform: rotate(-25deg);
    }

    .stamp-top span:nth-child(4) {
        transform: rotate(-10deg);
    }

    .stamp-top span:nth-child(5) {
        transform: rotate(5deg);
    }

    .stamp-top span:nth-child(6) {
        transform: rotate(20deg);
    }

    .stamp-top span:nth-child(7) {
        transform: rotate(35deg);
    }

    .stamp-top span:nth-child(8) {
        transform: rotate(50deg);
    }

    /* ========================= CENTER PAID ========================== */
    .paid-stamp .stamp-middle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1px;
        line-height: 1;
    }

    /* ========================= BOTTOM CIRCULAR TEXT ========================== */
    .stamp-bottom {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
    }

    .stamp-bottom span {
        position: absolute;
        left: 50%;
        bottom: 3px;
        transform-origin: 0 -29px;
        font-size: 6px;
        font-weight: 700;
        line-height: 1;
    }

    .stamp-bottom span:nth-child(1) {
        transform: rotate(55deg);
    }

    .stamp-bottom span:nth-child(2) {
        transform: rotate(40deg);
    }

    .stamp-bottom span:nth-child(3) {
        transform: rotate(25deg);
    }

    .stamp-bottom span:nth-child(4) {
        transform: rotate(10deg);
    }

    .stamp-bottom span:nth-child(5) {
        transform: rotate(-5deg);
    }

    .stamp-bottom span:nth-child(6) {
        transform: rotate(-20deg);
    }

    .stamp-bottom span:nth-child(7) {
        transform: rotate(-35deg);
    }

    .stamp-bottom span:nth-child(8) {
        transform: rotate(-50deg);
    }

    .receipt-footer-note {
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        margin-top: 10px;
        line-height: 1.2;
    }

    /* =========================
       POS THERMAL PRINT SETTINGS
    ========================== */

    .print-btn {
        margin-bottom: 10px;
        text-align: center;
    }

    .print-btn button {
        font-family: system-ui, -apple-system, sans-serif;
        cursor: pointer;
    }

    @media print {

        /* 1. Force the print media size to 80mm width with auto height */
        @page {
            size: 80mm auto;
            margin: 0mm !important;
            /* Removes browser header, footer, dates, & margins */
        }

        /* 2. Reset document body dimensions to match printer roll width */
        html,
        body {
            width: 80mm !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* 3. Hide all non-receipt wrapper elements */
        body * {
            visibility: hidden !important;
        }

        /* 4. Display the receipt centered and full width on the thermal paper */
        .receipt-wrapper,
        .receipt-wrapper * {
            visibility: visible !important;
        }

        .receipt-wrapper {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 80mm !important;
            max-width: 80mm !important;
            margin: 0 !important;
            padding: 4mm !important;
            /* Small padding so text doesn't touch paper edges */
        }

        .receipt {
            width: 100% !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* 5. Hide the print button on paper */
        .print-btn {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')

<div class="receipt-wrapper">

    <!-- Print Button -->
    <div class="print-btn">
        <button type="button" class="btn btn-primary" onclick="window.print()">
            <i class="bi bi-printer"></i> Print Receipt
        </button>
    </div>

    <!-- Receipt Container -->
    <div class="receipt">

        <!-- Top Branding -->
        <div class="receipt-brand-bar justify-content-center">
            <div class="brand-left">
                @if(!empty($settings->logo))
                <img src="{{ asset('uploads/settings/'.$settings->logo) }}" alt="{{ $settings->name }}">
                @else
                <img src="{{ asset('uploads/settings/default.png') }}" alt="{{ $settings->name }}">
                @endif
            </div>
            <div class="brand-right">
                <h2>{!! $settings->name !!}</h2>
            </div>
        </div>

        <!-- Receipt Main Heading -->
        <div class="receipt-main-title">RECEIPT</div>

        <!-- Customer Information Section -->
        <hr class="dashed-line">
        <div class="section-heading">Customer Information</div>
        <hr class="dashed-line">

        <div class="info-grid">
            <div class="info-row">
                <span class="info-value">Name</span>
                <span class="info-value">{{ strtoupper($collection->name) }}</span>
            </div>
            <div class="info-row">
                <span class="info-value">Member ID</span>
                <span class="info-value">{{ strtoupper($collection->unique_id) }}</span>
            </div>
            <div class="info-row">
                <span class="info-value">Holding No</span>
                <span class="info-value">{{ $collection->plot->holding_no ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-value">Road No</span>
                <span class="info-value">{{ $collection->plot->road ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-value">Mobile</span>
                <span class="info-value">{{ $collection->number }}</span>
            </div>
            <div class="info-row">
                <span class="info-value">Email</span>
                <span class="info-value">{{ $collection->email ?? '-' }}</span>
            </div>
        </div>

        <!-- Payment Information Section -->
        <hr class="dashed-line">
        <div class="section-heading">Payment Information</div>
        <hr class="dashed-line">

        <div class="info-grid">
            <div class="info-row">
                <span class="info-value">Issue Date</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($collection->date)->format('d F, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-value">Payment Date</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($collection->payment_date)->format('d F, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-value">Amount Paid</span>
                <span class="info-value">BDT {{ number_format($collection->collection_amount, 2) }}</span>
            </div>
            <div class="info-row">
                <span class="info-value">Payment Status</span>
                <span class="info-value">
                    {{ $collection->payment_status == 1 ? 'PAID' : 'UNPAID' }}
                </span>
            </div>
        </div>

        <!-- Amount in Words -->
        <hr class="dashed-line">
        <div class="info-grid">
            <div class="info-row d-flex align-items-start">
                <span class="info-value flex-shrink-0 me-2">In Words:</span>
                <span class="info-value text-start" style="font-size: 12px; line-height: 1.5;">{{ amountInWords($collection->collection_amount) }}</span>
            </div>
        </div>
        <hr class="dashed-line">

        <!-- Circular Stamp -->
        <div class="stamp-container">
            <div class="paid-stamp">
                <div class="stamp-top"> <span>T</span><span>H</span><span>A</span><span>N</span><span>K</span><span>Y</span><span>O</span><span>U</span> </div> <span class="stamp-middle">PAID</span>
                <div class="stamp-bottom"> <span>T</span><span>H</span><span>A</span><span>N</span><span>K</span><span>Y</span><span>O</span><span>U</span> </div>
            </div>
        </div>

        <!-- Footer Text -->
        <div class="receipt-footer-note">
            This receipt has been generated electronically
        </div>

    </div>

</div>

@endsection