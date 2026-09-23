<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\PlotAndUnit;
use App\Services\BillingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    protected BillingService $billingService;

    public function __construct(BillingService $billingService)
    {
        $this->billingService = $billingService;
    }

    public function index(Request $request)
    {
        $query = Bill::with(['plotAndUnit.road', 'payments'])->latest('billing_month');

        if ($request->filled('month')) {
            $query->where('billing_month', $request->month);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('bill_number', 'like', "%{$search}%")
                  ->orWhereHas('plotAndUnit', function ($pq) use ($search) {
                      $pq->where('holding_no', 'like', "%{$search}%")
                         ->orWhere('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $bills = $query->paginate(15)->withQueryString();

        // High-level ledger metrics
        $currentMonth = $request->get('month', now()->format('Y-m'));
        $stats = [
            'total_billed' => (float)Bill::where('billing_month', $currentMonth)->sum('net_amount'),
            'total_paid'   => (float)Bill::where('billing_month', $currentMonth)->sum('paid_amount'),
            'unpaid_count' => Bill::where('billing_month', $currentMonth)->whereIn('status', ['Unpaid', 'Partial'])->count(),
        ];

        return view('admin.bills.index', compact('bills', 'stats', 'currentMonth'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'billing_month' => ['required', 'date_format:Y-m'],
            'due_date'      => ['required', 'date'],
        ]);

        $result = $this->billingService->generateMonthlyBills(
            $validated['billing_month'],
            $validated['due_date']
        );

        return redirect()->route('admin.bills.index', ['month' => $validated['billing_month']])
            ->with('success', "Billing Complete: {$result['generated']} generated, {$result['skipped']} skipped (already existed).");
    }

    public function pay(Request $request, Bill $bill)
    {
        $due = $bill->due_balance;

        $validated = $request->validate([
            'amount'          => ['required', 'numeric', 'min:1', 'max:' . $due],
            'payment_date'    => ['required', 'date'],
            'method'          => ['required', 'in:Cash,bKash,Nagad,Bank Transfer,Cheque'],
            'transaction_ref' => ['nullable', 'string', 'max:100'],
            'notes'           => ['nullable', 'string'],
        ]);

        $this->billingService->recordPayment($bill, $validated, Auth::id());

        return back()->with('success', 'Payment recorded successfully.');
    }
}