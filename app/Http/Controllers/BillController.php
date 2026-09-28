<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\PlotAndUnit;
use App\Models\PlotType;
use App\Models\Road;
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
        $query = Bill::with(['plotAndUnit.road', 'plotAndUnit.plotType', 'payments'])->latest('billing_month');

        // 1. Billing Month Filter (Year + Month: e.g. '2026-09')
        if ($request->filled('month')) {
            $query->where('billing_month', $request->month);
        }

        // 2. Payment Status Filter (Unpaid, Partial, Paid)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Road Number Filter
        if ($request->filled('road_number')) {
            $roadNum = trim($request->road_number);
            $query->whereHas('plotAndUnit.road', function ($q) use ($roadNum) {
                $q->where('number', $roadNum);
            });
        }

        // 4. Plot Type Filter
        if ($request->filled('plot_type_id')) {
            $query->whereHas('plotAndUnit', function ($q) use ($request) {
                $q->where('plot_type_id', $request->plot_type_id);
            });
        }

        // 5. Keyword Search: Bill #, Holding No, Contact Name, Phone
        if ($request->filled('search')) {
            $search = trim($request->search);
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

        // High-level ledger metrics (Filtered Month or Default Current Month 'YYYY-MM')
        $currentMonth = $request->get('month', now()->format('Y-m'));

        $statsQuery = Bill::where('billing_month', $currentMonth);
        
        // Road filter metrics-e o apply korte chaile:
        if ($request->filled('road_number')) {
            $roadNum = trim($request->road_number);
            $statsQuery->whereHas('plotAndUnit.road', function ($q) use ($roadNum) {
                $q->where('number', $roadNum);
            });
        }

        $stats = [
            'total_billed' => (float)$statsQuery->sum('net_amount'),
            'total_paid'   => (float)$statsQuery->sum('paid_amount'),
            'unpaid_count' => (clone $statsQuery)->whereIn('status', ['Unpaid', 'Partial'])->count(),
        ];

        $roads = Road::orderBy('number')->get();
        $plotTypes = PlotType::where('status', 'Active')->get();

        return view('admin.bills.index', compact('bills', 'stats', 'currentMonth', 'roads', 'plotTypes'));
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
            ->with('success', $result['generated'] > 0 ? "Billing Generation: {$result['generated']} newly generated" : 'All the bill already generated');
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