<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\PlotAndUnit;
use App\Models\Setting;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    public function mypayments()
    {
        if (auth()->user()->role == 'admin') {
            $bills = Bill::paginate(30);
        } else {
            $bills = Bill::whereHas('plotAndUnit', function ($query) {
                $query->where('unique_id', auth()->user()->uid);
            })->paginate(30);
        }

        return view('members.index', compact('bills'));
    }

    public function receipt($id)
    {
        $collection = PlotAndUnit::findOrFail($id);
        $settings   = Setting::latest()->first();
        return view('members.receipt', compact('collection', 'settings'));
    }

    public function Pay()
    {
        dd("Under Construction");
    }

    public function paymentReport()
    {
        if (auth()->user()->role == 'admin') {
            $bills = Bill::where('status', 'Paid')->paginate(30);
        } else {
            $bills = Bill::whereHas('plotAndUnit', function ($query) {
                $query->where('unique_id', auth()->user()->uid);
            })->where('status', 'Paid')->paginate(30);
        }
        return view('members.payment_report', compact('bills'));
    }
}
