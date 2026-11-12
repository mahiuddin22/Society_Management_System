<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\PlotAndUnit;
use App\Models\Road;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
    public function index(Request $request)
    {
        $today = now()->toDateString();
        $monthStart = now()->startOfMonth();
        $monthKey = $monthStart->format('Y-m');
        $isCollector = auth()->user()?->role === 'collector';
        $assignedRoadIds = $isCollector
            ? Road::where('collector_id', auth()->id())->pluck('id')
            : collect();

        $billQuery = Bill::query();
        $paymentQuery = Payment::query();
        $plotQuery = PlotAndUnit::query();
        if ($isCollector) {
            $billQuery->whereHas('plotAndUnit', fn ($query) => $query->whereIn('road_id', $assignedRoadIds));
            $paymentQuery->whereHas('bill.plotAndUnit', fn ($query) => $query->whereIn('road_id', $assignedRoadIds));
            $plotQuery->whereIn('road_id', $assignedRoadIds);
        }

        $stats = [
            'today_collected' => (float) (clone $paymentQuery)->whereDate('payment_date', $today)->sum('amount'),
            'month_collected' => (float) (clone $paymentQuery)->whereBetween('payment_date', [$monthStart->toDateString(), now()->toDateString()])->sum('amount'),
            'outstanding' => (float) (clone $billQuery)->whereColumn('net_amount', '>', 'paid_amount')
                ->selectRaw('COALESCE(SUM(net_amount - paid_amount), 0) as total')->value('total'),
            'active_plots' => (clone $plotQuery)->where('status', 'Active')->count(),
            'unpaid_bills' => (clone $billQuery)->whereIn('status', ['Unpaid', 'Partial', 'Overdue'])->count(),
        ];

        $totalFlats = 0;
        if (auth()->user()?->role === 'admin') {
            $totalFlats = PlotAndUnit::query()->pluck('flat_numbers')->sum(function ($flatNumbers) {
                if (! filled($flatNumbers)) {
                    return 0;
                }

                return collect(explode(',', $flatNumbers))->filter(fn ($flat) => trim($flat) !== '')->count();
            });
        }

        $months = collect(range(5, 0))->map(function ($offset) {
            $date = now()->startOfMonth()->subMonths($offset);
            return ['key' => $date->format('Y-m'), 'label' => $date->format('M')];
        });
        $monthKeys = $months->pluck('key');
        $billedByMonth = (clone $billQuery)->whereIn('billing_month', $monthKeys)
            ->select('billing_month', DB::raw('SUM(net_amount) as total'))
            ->groupBy('billing_month')->pluck('total', 'billing_month');
        $firstMonth = now()->startOfMonth()->subMonths(5);
        $paymentsByMonth = (clone $paymentQuery)->whereBetween('payment_date', [$firstMonth->toDateString(), now()->toDateString()])
            ->get(['payment_date', 'amount'])
            ->groupBy(fn ($payment) => $payment->payment_date->format('Y-m'))
            ->map(fn ($payments) => (float) $payments->sum('amount'));
        $chartMonths = $months->map(fn ($month) => [
            'label' => $month['label'],
            'billed' => (float) ($billedByMonth[$month['key']] ?? 0),
            'collected' => (float) ($paymentsByMonth[$month['key']] ?? 0),
        ]);

        $monthBillStats = (clone $billQuery)->where('billing_month', $monthKey)
            ->selectRaw('COUNT(*) as count, COALESCE(SUM(net_amount), 0) as billed, COALESCE(SUM(paid_amount), 0) as collected')
            ->first();
        $monthBillCount = (int) $monthBillStats->count;
        $monthBilled = (float) $monthBillStats->billed;
        $monthPaid = (float) $monthBillStats->collected;
        $monthDue = max(0, $monthBilled - $monthPaid);

        $collectorSummary = null;
        if ($isCollector) {
            $collectorSummary = [
                'monthly_target' => $monthBilled,
                'monthly_collected' => $stats['month_collected'],
                'monthly_due' => $monthDue,
                'lifetime_collected' => (float) (clone $paymentQuery)->sum('amount'),
                'lifetime_due' => $stats['outstanding'],
            ];
        }

        $dashboardSummary = null;
        $dashboardPeriod = null;
        if (auth()->user()?->role === 'admin') {
            $period = $request->query('summary_period', 'month');
            $dashboardPeriod = in_array($period, ['week', 'month', 'year', 'total'], true) ? $period : 'month';
            $dashboardBillQuery = Bill::query();

            if ($dashboardPeriod !== 'total') {
                $start = match ($dashboardPeriod) {
                    'week' => now()->startOfWeek(),
                    'year' => now()->startOfYear(),
                    default => now()->startOfMonth(),
                };
                $dashboardBillQuery->whereBetween('created_at', [$start, now()]);
            }

            $summary = $dashboardBillQuery->selectRaw(
                'COALESCE(SUM(net_amount), 0) as total_amount, '
                .'COALESCE(SUM(CASE WHEN net_amount > paid_amount THEN net_amount - paid_amount ELSE 0 END), 0) as due_amount, '
                .'COALESCE(SUM(paid_amount), 0) as paid_amount'
            )->first();

            $dashboardSummary = [
                'total' => (float) $summary->total_amount,
                'due' => (float) $summary->due_amount,
                'paid' => (float) $summary->paid_amount,
            ];
        }

        $recentBills = (clone $billQuery)->with('plotAndUnit.road')->latest()->take(5)->get();
        $recentCollections = (clone $paymentQuery)->with(['bill.plotAndUnit', 'collector'])
            ->orderByDesc('payment_date')->orderByDesc('id')->take(5)->get();
        $recentPlots = (clone $plotQuery)->with(['road', 'plotType'])->where('status', 'Active')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'chartMonths', 'monthBilled', 'monthPaid', 'monthDue', 'monthBillCount',
            'recentBills', 'recentCollections', 'recentPlots', 'dashboardSummary', 'dashboardPeriod',
            'collectorSummary', 'isCollector', 'totalFlats'
        ));
    }

    public function notifications()
    {
        $items = collect();
        $role = auth()->user()?->role;
        $isCollector = $role === 'collector';
        $isMember = $role === 'member';
        $assignedRoadIds = $isCollector ? Road::where('collector_id', auth()->id())->pluck('id') : collect();
        $memberPlotIds = $isMember
            ? PlotAndUnit::where('unique_id', auth()->user()->uid)->pluck('id')
            : collect();

        $billMonths = Bill::query()
            ->when($isCollector, fn ($query) => $query->whereHas('plotAndUnit', fn ($plotQuery) => $plotQuery->whereIn('road_id', $assignedRoadIds)))
            ->when($isMember, fn ($query) => $query->whereHas('plotAndUnit', fn ($plotQuery) => $plotQuery->whereIn('id', $memberPlotIds)))
            ->whereNotNull('billing_month')
            ->select('billing_month')
            ->selectRaw('MAX(created_at) as latest_created_at')
            ->selectRaw('COUNT(*) as bill_count, COALESCE(SUM(net_amount - paid_amount), 0) as remaining_due')
            ->groupBy('billing_month')
            ->orderByDesc('latest_created_at')
            ->take(10)
            ->get();

        foreach ($billMonths as $billMonth) {
            $monthLabel = Carbon::hasFormat($billMonth->billing_month, 'Y-m')
                ? Carbon::createFromFormat('Y-m', $billMonth->billing_month)->format('F Y')
                : $billMonth->billing_month;
            $items->push([
                'id' => 'bill_month-' . $billMonth->billing_month,
                'record_id' => $billMonth->billing_month,
                'type' => 'bill_month',
                'title' => $isMember ? 'A bill for ' . $monthLabel . ' is available.' : 'New bill generated for the month of ' . $monthLabel . '.',
                'details' => $isMember
                    ? number_format((int) $billMonth->bill_count) . ' bill(s) · Remaining due ৳' . number_format((float) $billMonth->remaining_due, 2)
                    : '',
                'time' => Carbon::parse($billMonth->latest_created_at)->diffForHumans(),
                'timestamp' => Carbon::parse($billMonth->latest_created_at)->timestamp,
                'url' => $isMember ? route('member.mypayment') : route('admin.bills.index'),
            ]);
        }

        $payments = Payment::with('bill.plotAndUnit')
            ->when($isCollector, fn ($query) => $query->whereHas('bill.plotAndUnit', fn ($plotQuery) => $plotQuery->whereIn('road_id', $assignedRoadIds)))
            ->when($isMember, fn ($query) => $query->whereHas('bill.plotAndUnit', fn ($plotQuery) => $plotQuery->whereIn('id', $memberPlotIds)))
            ->latest()->take(10)->get();
        foreach ($payments as $payment) {
            $items->push([
                'id' => 'collection-' . $payment->id,
                'record_id' => $payment->id,
                'type' => 'collection',
                'title' => $isMember ? 'Your payment was recorded.' : 'New collection received',
                'details' => '৳' . number_format((float) $payment->amount, 2) . ($isMember
                    ? ' · Bill ' . ($payment->bill->bill_number ?? '')
                    : ' · ' . ($payment->bill->plotAndUnit->name ?? 'Resident') . ' · ' . ($payment->bill->plotAndUnit->phone ?? 'No phone')),
                'time' => $payment->created_at?->diffForHumans() ?? '',
                'timestamp' => $payment->created_at?->timestamp ?? 0,
                'url' => $isMember ? route('member.paymentreport') : route('admin.payments.index'),
            ]);
        }

        if (! $isMember) {
            $bulkPlotBatches = PlotAndUnit::whereNotNull('import_batch_id')
                ->when($isCollector, fn ($query) => $query->whereIn('road_id', $assignedRoadIds))
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

            $newPlots = PlotAndUnit::whereNull('import_batch_id')
                ->when($isCollector, fn ($query) => $query->whereIn('road_id', $assignedRoadIds))
                ->latest()->take(10)->get();
            foreach ($newPlots as $plot) {
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
        }

        $latestItems = $items->sortByDesc('timestamp')->take(10)->values();
        $latestKeys = $latestItems->pluck('id');
        $staleReadRows = DB::table('dashboard_notification_reads')->where('user_id', auth()->id());
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

        $isCollector = auth()->user()?->role === 'collector';
        $isMember = auth()->user()?->role === 'member';
        $assignedRoadIds = $isCollector ? Road::where('collector_id', auth()->id())->pluck('id') : collect();
        $memberPlotIds = $isMember
            ? PlotAndUnit::where('unique_id', auth()->user()->uid)->pluck('id')
            : collect();
        $exists = match ($data['type']) {
            'bill_month' => Bill::where('billing_month', $data['id'])
                ->when($isCollector, fn ($query) => $query->whereHas('plotAndUnit', fn ($plotQuery) => $plotQuery->whereIn('road_id', $assignedRoadIds)))
                ->when($isMember, fn ($query) => $query->whereHas('plotAndUnit', fn ($plotQuery) => $plotQuery->whereIn('id', $memberPlotIds)))
                ->exists(),
            'collection' => Payment::whereKey($data['id'])
                ->when($isCollector, fn ($query) => $query->whereHas('bill.plotAndUnit', fn ($plotQuery) => $plotQuery->whereIn('road_id', $assignedRoadIds)))
                ->when($isMember, fn ($query) => $query->whereHas('bill.plotAndUnit', fn ($plotQuery) => $plotQuery->whereIn('id', $memberPlotIds)))
                ->exists(),
            'plot' => PlotAndUnit::whereKey($data['id'])
                ->when($isCollector, fn ($query) => $query->whereIn('road_id', $assignedRoadIds))
                ->when($isMember, fn ($query) => $query->whereRaw('1 = 0'))
                ->exists(),
            'bulk_plot' => PlotAndUnit::where('import_batch_id', $data['id'])
                ->when($isCollector, fn ($query) => $query->whereIn('road_id', $assignedRoadIds))
                ->when($isMember, fn ($query) => $query->whereRaw('1 = 0'))
                ->exists(),
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
        $user = auth()->user();
        $plots = $user->role === 'member' && filled($user->uid)
            ? PlotAndUnit::with(['road', 'plotType'])->where('unique_id', $user->uid)->orderBy('holding_no')->get()
            : collect();

        return view('admin.profile.profile', compact('user', 'plots'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('profile_image')) {
            $directory = public_path('uploads/users');
            File::ensureDirectoryExists($directory);

            if ($user->profile_image && str_starts_with($user->profile_image, 'uploads/users/') && is_file(public_path($user->profile_image))) {
                @unlink(public_path($user->profile_image));
            }

            $extension = $request->file('profile_image')->extension();
            $filename = $user->id . '.' . $extension;
            $request->file('profile_image')->move($directory, $filename);
            $data['profile_image'] = 'uploads/users/' . $filename;
        }

        $user->update($data);
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user->update(['password' => bcrypt($data['new_password'])]);
        return redirect()->back()->with('success', 'Password updated successfully.');
    }
    
}
