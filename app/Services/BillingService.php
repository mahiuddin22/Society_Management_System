<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\PlotAndUnit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BillingService
{
    /**
     * Generate bills for all active holdings for a specific month.
     */
    public function generateMonthlyBills(string $month, string $dueDate): array
    {
        // Changed from 'plot_type' to 'plotType'
        $properties = PlotAndUnit::with('plotType')
            ->where('status', 'Active')
            ->get();

        $generated = 0;
        $skipped   = 0;

        foreach ($properties as $property) {
            // Skip if bill already exists for this month
            $exists = Bill::where('plot_and_unit_id', $property->id)
                ->where('billing_month', $month)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            $this->createBillForProperty($property, $month, $dueDate);
            $generated++;
        }

        return [
            'total_active' => $properties->count(),
            'generated'    => $generated,
            'skipped'      => $skipped,
        ];
    }

    /**
     * Create single snapshot bill for a holding following plot type rules.
     */
    public function createBillForProperty(PlotAndUnit $property, string $month, string $dueDate): Bill
    {
        return DB::transaction(function () use ($property, $month, $dueDate) {
            // Access via camelCase relation: plotType
            $slug = $property->plotType?->slug ?? '';
            $isExempt = in_array($slug, ['under-construction', 'empty-plot']);

            // Business Rules:
            // Land / Under-Construction -> strictly 1 billing unit (0 occupied flats)
            // Regular Properties -> occupied flats count (fallback to 1 if empty)
            $billingUnits = $isExempt 
                ? 1 
                : ($property->occupied_flat > 0 ? (int)$property->occupied_flat : 1);

            $rate     = (float)$property->collection_rate;
            $discount = (float)$property->discount;

            $grossAmount = $rate * $billingUnits;
            $netAmount   = max(0.00, $grossAmount - $discount);

            // Convert YYYY-MM (e.g. 2026-09) -> MMYYYY (e.g. 092026)
            $monthYear = Carbon::parse($month)->format('mY');

            // Preserve slashes in holding number (e.g. 09/B) without converting to dash
            $cleanHolding = strtoupper(preg_replace('/[^A-Za-z0-9\/]/', '', $property->holding_no ?: '00'));

            // Bill number format: BIL-MMYYYY-Holding-Random
            // Output example: BIL-092026-09/B-XC2Z
            $billNumber = sprintf(
                'BIL-%s-%s-%s',
                $monthYear,
                $cleanHolding,
                strtoupper(Str::random(4))
            );

            return Bill::create([
                'plot_and_unit_id'  => $property->id,
                'bill_number'       => $billNumber,
                'billing_month'     => $month,
                'due_date'          => $dueDate,
                'plot_type_name'    => $property->plotType?->name ?? 'Standard',
                'billing_units'     => $billingUnits,
                'rate_snapshot'     => $rate,
                'discount_snapshot' => $discount,
                'gross_amount'      => $grossAmount,
                'net_amount'        => $netAmount,
                'paid_amount'       => 0.00,
                'status'            => $netAmount == 0 ? 'Paid' : 'Unpaid',
            ]);
        });
    }

    /**
     * Record a payment and update bill status.
     */
    public function recordPayment(Bill $bill, array $data, ?int $userId = null): Payment
    {
        return DB::transaction(function () use ($bill, $data, $userId) {
            $paymentAmount = (float)$data['amount'];

            // Auto-generate transaction_ref if missing
            $trxRef = !empty($data['transaction_ref'])
                ? trim($data['transaction_ref'])
                : 'TRX-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

            $payment = Payment::create([
                'bill_id'         => $bill->id,
                'payment_number'  => 'REC-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
                'amount'          => $paymentAmount,
                'payment_date'    => $data['payment_date'] ?? now()->toDateString(),
                'method'          => $data['method'] ?? 'Cash',
                'transaction_ref' => $trxRef,
                'received_by'     => $userId,
                'notes'           => $data['notes'] ?? null,
            ]);

            $newPaid = (float)$bill->paid_amount + $paymentAmount;
            $bill->paid_amount = $newPaid;

            if ($newPaid >= (float)$bill->net_amount) {
                $bill->status = 'Paid';
            } elseif ($newPaid > 0) {
                $bill->status = 'Partial';
            }
            $bill->save();

            return $payment;
        });
    }
}