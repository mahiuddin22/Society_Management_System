@extends('admin.layouts.app')

@push('styles')
<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        background: #f2f2f2;
        font-family: "Kindly Rewind", Helvetica, Arial, sans-serif;
        color: #222;
        font-size: 13px;
    }

    .receipt-wrapper {
        width: 100%;
        max-width: 850px;
        margin: 30px auto;
    }

    .receipt {
        width: 100%;
        background: #fff;
        padding: 35px 40px;
        border: 1px solid #d5d5d5;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        font-family: Helvetica, Arial, sans-serif;
    }

    /* =========================
       HEADER
    ========================== */

    .receipt-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 18px;
        border-bottom: 2px solid #222;
        margin-bottom: 20px;
    }

    .company-brand {
        width: 60%;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .company-brand>img {
        width: 75px;
        height: 75px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .company-info {
        width: auto;
        flex: 1;
    }

    .company-info h2 {
        margin: 0 0 6px;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 700;
        color: #111;
    }

    .company-info p {
        margin: 2px 0;
        font-size: 12px;
        line-height: 1.5;
        color: #555;
    }

    .receipt-title {
        width: 40%;
        text-align: right;
    }

    .receipt-title h1 {
        margin: 0;
        font-size: 24px;
        line-height: 1.2;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #111;
    }

    .receipt-title p {
        margin: 5px 0 0;
        font-size: 11px;
        color: #666;
    }

    /* =========================
       RECEIPT META
    ========================== */

    .receipt-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .meta-item {
        line-height: 1.5;
    }

    .meta-item strong {
        font-weight: 700;
        margin-right: 5px;
    }

    /* =========================
       SECTION TITLE
    ========================== */

    .section-title {
        background: #f5f5f5;
        border: 1px solid #ccc;
        padding: 8px 10px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #222;
    }

    /* =========================
       CUSTOMER TABLE
    ========================== */

    .customer-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .customer-table td {
        border: 1px solid #ccc;
        padding: 9px 10px;
        font-size: 13px;
        line-height: 1.4;
        vertical-align: middle;
    }

    .customer-table td:nth-child(odd) {
        width: 17%;
        background: #fafafa;
        font-weight: 700;
        color: #333;
    }

    .customer-table td:nth-child(even) {
        width: 33%;
        color: #444;
    }

    /* =========================
       PAYMENT TABLE
    ========================== */

    .payment-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .payment-table th {
        background: #f5f5f5;
        border: 1px solid #ccc;
        padding: 9px 10px;
        font-size: 13px;
        font-weight: 700;
        text-align: left;
        color: #222;
    }

    .payment-table td {
        border: 1px solid #ccc;
        padding: 10px;
        font-size: 13px;
        line-height: 1.4;
        vertical-align: middle;
    }

    .payment-table .amount {
        text-align: right;
        font-weight: 700;
        white-space: nowrap;
    }

    .payment-table .total-row td {
        font-weight: 700;
        font-size: 14px;
    }

    /* =========================
       PAYMENT STATUS
    ========================== */

    .status-paid {
        display: inline-block;
        padding: 4px 12px;
        border: 1px solid #198754;
        color: #198754;
        background: #f1faf5;
        border-radius: 3px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.4px;
    }

    .status-unpaid {
        display: inline-block;
        padding: 4px 12px;
        border: 1px solid #dc3545;
        color: #dc3545;
        background: #fff5f5;
        border-radius: 3px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.4px;
    }

    /* =========================
       AMOUNT IN WORDS
    ========================== */

    .amount-words {
        border: 1px solid #ccc;
        padding: 11px 12px;
        margin-bottom: 55px;
        font-size: 13px;
        line-height: 1.5;
    }

    .amount-words strong {
        font-weight: 700;
    }

    /* =========================
       SIGNATURE
    ========================== */

    .signature-area {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 60px;
        margin-bottom: 30px;
    }

    .signature {
        width: 200px;
        text-align: center;
    }

    .signature-line {
        width: 100%;
        border-top: 1px solid #222;
        margin-bottom: 7px;
    }

    .signature span {
        display: block;
        font-size: 12px;
        color: #333;
    }

    /* =========================
       FOOTER
    ========================== */

    .receipt-footer {
        border-top: 1px solid #ccc;
        padding-top: 10px;
        text-align: center;
        font-size: 10px;
        color: #777;
        line-height: 1.4;
    }

    /* =========================
       PRINT BUTTON
    ========================== */

    .print-btn {
        margin-bottom: 15px;
        text-align: right;
    }

    .print-btn button {
        font-family: Helvetica, Arial, sans-serif;
        cursor: pointer;
    }

    /* =========================
       STRAIGHT HR LINE
    ========================== */

    .receipt hr {
        border: 0;
        border-top: 1px solid #222;
        height: 0;
        margin: 10px 0;
    }

    /* =========================
       PRINT
    ========================== */

    @media print {

        @page {
            size: A4;
            margin: 15mm;
        }

        html,
        body {
            width: 100%;
            height: auto;
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }

        body * {
            visibility: hidden !important;
        }

        .receipt,
        .receipt * {
            visibility: visible !important;
        }

        .receipt-wrapper {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: none;
            margin: 0 !important;
            padding: 0 !important;
        }

        .receipt {
            position: relative;
            width: 100%;
            margin: 0 !important;
            padding: 10px !important;
            border: none !important;
            box-shadow: none !important;
            background: #fff !important;
        }

        .print-btn {
            display: none !important;
        }

        .receipt-header {
            border-bottom: 2px solid #222;
        }

        .section-title,
        .customer-table td,
        .payment-table th,
        .payment-table td {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .status-paid,
        .status-unpaid {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }

    /* =========================
       MOBILE
    ========================== */

    @media screen and (max-width: 768px) {

        .receipt-wrapper {
            margin: 10px auto;
            padding: 10px;
        }

        .receipt {
            padding: 20px;
        }

        .receipt-header {
            flex-direction: column;
            gap: 15px;
        }

        .company-brand {
            width: 60%;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .company-brand>img {
            width: 75px;
            height: 75px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .company-info h2 {
            margin: 0 0 6px;
            font-size: 24px;
            line-height: 1.2;
            font-weight: 700;
            color: #111;
        }

        .company-info p {
            margin: 2px 0;
            font-size: 12px;
            line-height: 1.5;
            color: #555;
        }

        .company-brand,
        .receipt-title {
            width: 100%;
        }

        .company-brand {
            align-items: flex-start;
        }

        .receipt-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .customer-table,
        .payment-table {
            font-size: 12px;
        }

        .customer-table td,
        .payment-table th,
        .payment-table td {
            padding: 7px;
        }

        .signature-area {
            margin-top: 40px;
        }

        .signature {
            width: 150px;
        }
    }
</style>
@endpush

@section('content')

<div class="receipt-wrapper">

    <div class="text-end print-btn">
        <button type="button" class="btn btn-primary" onclick="window.print()">
            <i class="bi bi-printer"></i>
            Print Receipt
        </button>
    </div>

    <div class="receipt">

        <!-- {{-- Header --}} -->
        <div class="receipt-header">
            <div class="company-brand">

                @if($settings->logo)
                <img src="{{ asset('uploads/settings/'.$settings->logo) }}" alt="{{ $settings->name }}">
                @else
                <img src="{{ asset('uploads/settings/default.png') }}" alt="{{ $settings->name }}">
                @endif

                <div class="company-info">
                    <h2>{!! $settings->name !!}</h2>
                    <p>{!! $settings->address !!}</p>
                    <p>Phone: {!! $settings->contact !!}</p>
                    <p>Email: {!! $settings->email !!}</p>
                </div>
            </div>

            <div class="receipt-title">
                <h1>Money Receipt</h1>
                <p>Official Payment Receipt</p>
            </div>
        </div>

        <!-- {{-- Receipt Information --}} -->
        <div class="receipt-meta">

            <div class="meta-item">
                <strong>Receipt No:</strong>
                {{$invoiceNo}}
            </div>

            <div class="meta-item">
                <strong>Date:</strong>
                {{ now()->format('d M Y') }}
            </div>

        </div>

        <!-- {{-- Customer Information --}} -->
        <div class="section-title">
            Customer Information
        </div>

        <table class="customer-table">
            <tr>
                <td>Holding No</td>
                <td>{{ $member->plot->holding_no ?? '-' }}</td>

                <td>Road No</td>
                <td>{{ $member->plot->road ?? '-' }}</td>
            </tr>

            <tr>
                <td>Name</td>
                <td>{{ $member->name }}</td>

                <td>Mobile</td>
                <td>{{ $member->number }}</td>
            </tr>

            <tr>
                <td>Email</td>
                <td colspan="3">{{ $member->email ?? '-' }}</td>
            </tr>
        </table>

        <!-- {{-- Payment Information --}} -->
        <div class="section-title">Payment Information</div>

        <table class="payment-table">

            <thead>
                <tr>
                    <th width="10%">SL</th>
                    <th>Description</th>
                    <th width="25%">Amount</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>01</td>

                    <td>
                        Collection / Payment
                    </td>

                    <td class="amount">
                        ৳ {{ number_format($member->amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="amount">
                        Total Amount
                    </td>

                    <td class="amount">
                        ৳ {{ number_format($member->amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="amount">
                        Payment Status
                    </td>

                    <td>
                        @if($member->payment_status == 1)
                        <span class="status-paid">PAID</span>
                        @else
                        <span class="status-unpaid">UNPAID</span>
                        @endif
                    </td>
                </tr>

            </tbody>

        </table>

        <!-- {{-- Amount in Words --}} -->
        <div class="amount-words">
            <strong>Amount in Words:</strong>
            {{ amountInWords($member->amount) }}
        </div>

        {{-- Signature --}}
        <div class="signature-area">

            <div class="signature">
                <div class="signature-line"></div>
                <span>Customer Signature</span>
            </div>

            <div class="signature">
                <div class="signature-line"></div>
                <span>Authorized Signature</span>
            </div>

        </div>

        {{-- Footer --}}
        <div class="receipt-footer">
            This is a computer-generated money receipt.
            Thank you for your payment.
        </div>

    </div>

</div>

@endsection