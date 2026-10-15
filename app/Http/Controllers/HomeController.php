<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\PlotAndUnit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = now()->toDateString();
        $monthStart = now()->startOfMonth();
        $monthKey = $monthStart->format('Y-m');

        $stats = [
            'today_collected' => (float) Payment::whereDate('payment_date', $today)->sum('amount'),
            'month_collected' => (float) Payment::whereBetween('payment_date', [$monthStart->toDateString(), now()->toDateString()])->sum('amount'),
            'outstanding' => (float) Bill::whereColumn('net_amount', '>', 'paid_amount')
                ->selectRaw('COALESCE(SUM(net_amount - paid_amount), 0) as total')->value('total'),
            'active_plots' => PlotAndUnit::where('status', 'Active')->count(),
            'unpaid_bills' => Bill::whereIn('status', ['Unpaid', 'Partial', 'Overdue'])->count(),
        ];

        $months = collect(range(5, 0))->map(function ($offset) {
            $date = now()->startOfMonth()->subMonths($offset);
            return ['key' => $date->format('Y-m'), 'label' => $date->format('M')];
        });
        $monthKeys = $months->pluck('key');
        $billedByMonth = Bill::whereIn('billing_month', $monthKeys)
            ->select('billing_month', DB::raw('SUM(net_amount) as total'))
            ->groupBy('billing_month')->pluck('total', 'billing_month');
        $firstMonth = now()->startOfMonth()->subMonths(5);
        $paymentsByMonth = Payment::whereBetween('payment_date', [$firstMonth->toDateString(), now()->toDateString()])
            ->get(['payment_date', 'amount'])
            ->groupBy(fn ($payment) => $payment->payment_date->format('Y-m'))
            ->map(fn ($payments) => (float) $payments->sum('amount'));
        $chartMonths = $months->map(fn ($month) => [
            'label' => $month['label'],
            'billed' => (float) ($billedByMonth[$month['key']] ?? 0),
            'collected' => (float) ($paymentsByMonth[$month['key']] ?? 0),
        ]);

        $monthBillStats = Bill::where('billing_month', $monthKey)
            ->selectRaw('COUNT(*) as count, COALESCE(SUM(net_amount), 0) as billed, COALESCE(SUM(paid_amount), 0) as collected')
            ->first();
        $monthBillCount = (int) $monthBillStats->count;
        $monthBilled = (float) $monthBillStats->billed;
        $monthPaid = (float) $monthBillStats->collected;
        $monthDue = max(0, $monthBilled - $monthPaid);

        $recentBills = Bill::with('plotAndUnit.road')->latest()->take(5)->get();
        $recentCollections = Payment::with(['bill.plotAndUnit', 'collector'])
            ->orderByDesc('payment_date')->orderByDesc('id')->take(5)->get();
        $recentPlots = PlotAndUnit::with(['road', 'plotType'])->where('status', 'Active')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'chartMonths', 'monthBilled', 'monthPaid', 'monthDue', 'monthBillCount',
            'recentBills', 'recentCollections', 'recentPlots'
        ));
    }

    public function notifications()
    {
        $items = collect();

        $billMonths = Bill::query()
            ->select('billing_month')
            ->selectRaw('MAX(created_at) as latest_created_at')
            ->groupBy('billing_month')
            ->orderByDesc('latest_created_at')
            ->take(10)
            ->get();

        foreach ($billMonths as $billMonth) {
            $items->push([
                'id' => 'bill_month-' . $billMonth->billing_month,
                'record_id' => $billMonth->billing_month,
                'type' => 'bill_month',
                'title' => 'New bill generated for the month of ' . Carbon::createFromFormat('Y-m', $billMonth->billing_month)->format('F Y') . '.',
                'details' => '',
                'time' => Carbon::parse($billMonth->latest_created_at)->diffForHumans(),
                'timestamp' => Carbon::parse($billMonth->latest_created_at)->timestamp,
                'url' => route('admin.bills.index'),
            ]);
        }

        foreach (Payment::with('bill.plotAndUnit')->latest()->take(10)->get() as $payment) {
            $items->push([
                'id' => 'collection-' . $payment->id,
                'record_id' => $payment->id,
                'type' => 'collection',
                'title' => 'New collection received',
                'details' => '৳' . number_format((float) $payment->amount, 0) . ' · ' . ($payment->bill->plotAndUnit->name ?? 'Resident') . ' · ' . ($payment->bill->plotAndUnit->phone ?? 'No phone'),
                'time' => $payment->created_at?->diffForHumans() ?? '',
                'timestamp' => $payment->created_at?->timestamp ?? 0,
                'url' => route('admin.payments.index'),
            ]);
        }

        $bulkPlotBatches = PlotAndUnit::whereNotNull('import_batch_id')
            ->select('import_batch_id')
            ->selectRaw('MAX(created_at) as latest_created_at, COUNT(*) as plot_count')
            ->groupBy('import_batch_id')
            ->orderByDesc('latest_created_at')
            ->take(10)
            ->get();

        foreach ($bulkPlotBatches as $batch) {
            $batchTime = Carbon::parse($batch->latest_created_at);
            $items->push([
                'id' => 'bulk_plot-' . $batch->import_batch_id,
                'record_id' => $batch->import_batch_id,
                'type' => 'bulk_plot',
                'title' => 'New Plots Uploaded',
                'details' => number_format($batch->plot_count) . ' plot / unit records',
                'time' => $batchTime->diffForHumans(),
                'timestamp' => $batchTime->timestamp,
                'url' => route('admin.plot-and-units.index'),
            ]);
        }

        foreach (PlotAndUnit::whereNull('import_batch_id')->latest()->take(10)->get() as $plot) {
            $items->push([
                'id' => 'plot-' . $plot->id,
                'record_id' => $plot->id,
                'type' => 'plot',
                'title' => 'New plot / unit added',
                'details' => $plot->name . ' · ' . ($plot->phone ?? 'No phone') . ' · Holding ' . $plot->holding_no,
                'time' => $plot->created_at?->diffForHumans() ?? '',
                'timestamp' => $plot->created_at?->timestamp ?? 0,
                'url' => route('admin.plot-and-units.show', $plot->id),
            ]);
        }

        $latestItems = $items->sortByDesc('timestamp')->take(10)->values();
        $latestKeys = $latestItems->pluck('id');
        $staleReadRows = DB::table('dashboard_notification_reads');
        if ($latestKeys->isNotEmpty()) {
            $staleReadRows->whereNotIn('notification_key', $latestKeys);
        }
        $staleReadRows->delete();

        $readKeys = DB::table('dashboard_notification_reads')
            ->where('user_id', auth()->id())
            ->whereIn('notification_key', $latestKeys)
            ->pluck('notification_key')
            ->all();

        $notifications = $latestItems->map(function ($item) use ($readKeys) {
            $item['unseen'] = ! in_array($item['id'], $readKeys, true);
            return $item;
        });

        return response()->json([
            'notifications' => $notifications,
            'unseen_count' => $notifications->where('unseen', true)->count(),
        ]);
    }

    public function markNotificationRead(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:bill_month,collection,plot,bulk_plot'],
        ]);
        $data += $request->validate([
            'id' => $data['type'] === 'bill_month'
                ? ['required', 'date_format:Y-m']
                : ($data['type'] === 'bulk_plot'
                    ? ['required', 'uuid']
                    : ['required', 'integer', 'min:1']),
        ]);

        $exists = match ($data['type']) {
            'bill_month' => Bill::where('billing_month', $data['id'])->exists(),
            'collection' => Payment::whereKey($data['id'])->exists(),
            'plot' => PlotAndUnit::whereKey($data['id'])->exists(),
            'bulk_plot' => PlotAndUnit::where('import_batch_id', $data['id'])->exists(),
        };

        if (! $exists) {
            return response()->json(['message' => 'Notification not found.'], 404);
        }

        DB::table('dashboard_notification_reads')->insertOrIgnore([
            'user_id' => auth()->id(),
            'notification_key' => $data['type'] . '-' . $data['id'],
            'viewed_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function profile()
    {
        return view('admin.profile.profile');
    }
}
