<?php

namespace App\Http\Controllers;

use App\Models\Road;
use App\Models\User;
use App\Models\Payment;
use App\Exports\ReportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class CollectorController extends Controller
{
    public function index()
    {
        $collectors = User::with(['assignedRoads' => function ($query) {
            $query->orderBy('number');
        }])->where('role', 'collector');

        if (request()->has('search')  && request()->get('search') != '') {
            $collectors = $collectors->where(function ($query) {
                $query->where('name', 'like', '%' . request()->get('search') . '%')
                    ->orWhere('email', 'like', '%' . request()->get('search') . '%');
            });
        }

        $collectors = $collectors->orderBy('name')->paginate(10);
        return view('admin.collectors.index', compact('collectors'));
    }

    public function paymentHistory($id)
    {
        $collector = User::with(['assignedRoads' => function ($query) {
            $query->orderBy('number');
        }])->where('role', 'collector')->findOrFail($id);

        if (auth()->user()->role === 'collector' && auth()->id() !== $collector->id) {
            abort(403);
        }

        if (! in_array(auth()->user()->role, ['admin', 'collector'], true)) {
            abort(403);
        }

        $currentMonth = now()->startOfMonth();
        $firstMonth = $currentMonth->copy()->subMonths(11);
        $firstMonthKey = $firstMonth->format('Y-m');
        $currentMonthKey = $currentMonth->format('Y-m');
        $roadIds = $collector->assignedRoads->pluck('id');

        $monthlyTargets = DB::table('bills')
            ->join('plot_and_units', 'plot_and_units.id', '=', 'bills.plot_and_unit_id')
            ->whereIn('plot_and_units.road_id', $roadIds)
            ->whereBetween('bills.billing_month', [$firstMonthKey, $currentMonthKey])
            ->select('bills.billing_month')
            ->selectRaw('SUM(bills.net_amount) as target_amount')
            ->groupBy('bills.billing_month')
            ->pluck('target_amount', 'billing_month');

        $paymentsByMonth = DB::table('payments')
            ->join('bills', 'bills.id', '=', 'payments.bill_id')
            ->join('plot_and_units', 'plot_and_units.id', '=', 'bills.plot_and_unit_id')
            ->whereIn('plot_and_units.road_id', $roadIds)
            ->whereBetween('bills.billing_month', [$firstMonthKey, $currentMonthKey])
            ->whereDate('payments.payment_date', '<=', now()->toDateString())
            ->select('bills.billing_month')
            ->selectRaw('DATE(payments.payment_date) as paid_on, SUM(payments.amount) as collected_amount')
            ->groupBy('bills.billing_month', DB::raw('DATE(payments.payment_date)'))
            ->orderBy('paid_on')
            ->get()
            ->groupBy('billing_month');

        $performanceMonths = collect(range(0, 11))->map(function ($offset) use ($firstMonth, $monthlyTargets, $paymentsByMonth, $currentMonthKey) {
            $month = $firstMonth->copy()->addMonths($offset);
            $monthKey = $month->format('Y-m');
            $target = (float) ($monthlyTargets[$monthKey] ?? 0);
            $dailyPayments = $paymentsByMonth->get($monthKey, collect());
            $collected = (float) $dailyPayments->sum('collected_amount');
            $due = max(0, $target - $collected);
            $completionDate = null;

            if ($target > 0) {
                $runningTotal = 0;
                foreach ($dailyPayments as $dailyPayment) {
                    $runningTotal += (float) $dailyPayment->collected_amount;
                    if ($runningTotal >= $target) {
                        $completionDate = Carbon::parse($dailyPayment->paid_on);
                        break;
                    }
                }
            }

            $daysToComplete = $completionDate
                ? $month->copy()->startOfMonth()->diffInDays($completionDate) + 1
                : null;

            return [
                'key' => $monthKey,
                'label' => $month->format('M Y'),
                'target' => $target,
                'collected' => $collected,
                'due' => $due,
                'performance' => $target > 0 ? min(100, ($collected / $target) * 100) : 0,
                'days_to_complete' => $daysToComplete,
                'completion_status' => $target <= 0
                    ? 'No bills'
                    : ($daysToComplete !== null ? $daysToComplete . ' days' : ($monthKey === $currentMonthKey ? 'In progress' : 'Not completed')),
            ];
        });

        $performanceSummary = [
            'target' => (float) $performanceMonths->sum('target'),
            'collected' => (float) $performanceMonths->sum('collected'),
            'due' => (float) $performanceMonths->sum('due'),
        ];
        $performanceSummary['rate'] = $performanceSummary['target'] > 0
            ? min(100, ($performanceSummary['collected'] / $performanceSummary['target']) * 100)
            : 0;

        $request = request();
        $request->validate(['month' => ['nullable', 'date_format:Y-m']]);

        $query = Payment::with(['bill.plotAndUnit.road', 'collector'])
            ->whereHas('bill.plotAndUnit.road', function ($query) use ($collector) {
                $query->where('collector_id', $collector->id);
            });

        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->input('month'));
            $query->whereYear('payment_date', $year)->whereMonth('payment_date', $month);
        }

        $export = strtolower((string) $request->query('export'));
        if (in_array($export, ['csv', 'xlsx'], true)) {
            $rows = $query->latest('payment_date')->latest('id')->get();
            $exportRows = $rows->map(fn ($payment) => [
                $payment->payment_date?->format('Y-m-d'),
                $payment->payment_number,
                $payment->bill?->bill_number,
                $payment->bill?->plotAndUnit?->holding_no,
                $payment->bill?->plotAndUnit?->name,
                $payment->bill?->plotAndUnit?->road?->number,
                $payment->method,
                $payment->transaction_ref,
                $payment->collector?->name,
                $payment->amount,
            ])->all();

            $format = $export === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX;
            return Excel::download(
                new ReportExport(['Date', 'Receipt', 'Bill', 'Holding', 'Resident', 'Road', 'Method', 'Transaction', 'Received By', 'Amount'], $exportRows),
                'collector-' . $collector->id . '-payments.' . ($export === 'csv' ? 'csv' : 'xlsx'),
                $format
            );
        }

        $totalAmount = (clone $query)->sum('amount');
        $payments = $query->latest('payment_date')->latest('id')->paginate(20)->withQueryString();

        return view('admin.collectors.payment_history', compact(
            'collector', 'payments', 'totalAmount', 'performanceMonths', 'performanceSummary'
        ));
    }

    // public function edit($id)
    // {
    //     $collector = User::findOrFail($id);
    //     return view('admin.collectors.edit', compact('collector'));
    // }

    public function update(Request $request, $id)
    {
        $collector = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,',
            'role'      => 'required',
        ]);

        $collector->name    = $request->name;
        $collector->email   = $request->email;
        $collector->role    = $request->role;
        $collector->save();

        return redirect()
            ->route('admin.collectors.index')
            ->with('success', 'Collector updated successfully.');
    }

    public function assignRoad($id)
    {
        $collector = User::findOrFail($id);
        $roads = Road::all();
        return view('admin.collectors.assign_road', compact('collector', 'roads'));
    }

    public function updateRoad($id, Request $request)
    {
        $collector = User::findOrFail($id);

        Road::where('collector_id', $collector->id)
            ->update(['collector_id' => null]);

        if ($request->filled('roads')) {
            Road::whereIn('id', $request->roads)
                ->where(function ($query) use ($collector) {
                    $query->whereNull('collector_id')->orWhere('collector_id', $collector->id);
                })
                ->update(['collector_id' => $collector->id]);
        }

        return redirect()
            ->route('admin.collectors.index')
            ->with('success', 'Roads assigned successfully.');
    }
    
}
