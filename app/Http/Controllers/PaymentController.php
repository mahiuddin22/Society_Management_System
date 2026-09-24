<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Road;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['bill.plotAndUnit.road', 'collector'])->latest('payment_date')->latest('id');

        // Filter: Payment Method
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        // Filter: Date Range
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        // Filter: Road Number
        if ($request->filled('road_number')) {
            $query->whereHas('bill.plotAndUnit.road', function ($q) use ($request) {
                $q->where('number', $request->road_number);
            });
        }

        // Search: Receipt #, Trx ID, Holding, Resident, Phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('payment_number', 'like', "%{$search}%")
                  ->orWhere('transaction_ref', 'like', "%{$search}%")
                  ->orWhereHas('bill', function ($bq) use ($search) {
                      $bq->where('bill_number', 'like', "%{$search}%")
                         ->orWhereHas('plotAndUnit', function ($pq) use ($search) {
                             $pq->where('holding_no', 'like', "%{$search}%")
                                ->orWhere('name', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                         });
                  });
            });
        }

        $payments = $query->paginate(15)->withQueryString();
        $roads = Road::orderBy('number')->get();

        // 5 Key Financial Summary Metrics
        $today = now()->toDateString();
        $stats = [
            'total_collected' => (float)Payment::sum('amount'),
            'today_collected' => (float)Payment::whereDate('payment_date', $today)->sum('amount'),
            'cash_collected'  => (float)Payment::where('method', 'Cash')->sum('amount'),
            'mfs_collected'   => (float)Payment::whereIn('method', ['bKash', 'Nagad'])->sum('amount'),
            'total_count'     => Payment::count(),
        ];

        return view('admin.payments.index', compact('payments', 'roads', 'stats'));
    }
}