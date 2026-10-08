<?php

namespace App\Http\Controllers;

use App\Models\PlotAndUnit;
use App\Models\Setting;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    public function mypayments(){
        if(auth()->user()->role == 'admin'){
            $data = PlotAndUnit::paginate(30);
        }else{
            $data = PlotAndUnit::where('unique_id', auth()->user()->uid)->paginate(30);
        }
        return view('members.index', compact('data'));
    }
    
    public function receipt($id)
    {
        $collection = PlotAndUnit::findOrFail($id);
        $settings   = Setting::latest()->first();
        return view('members.receipt', compact('collection', 'settings'));
    }

    public function Pay(){
        dd("Under Construction");
    }

    public function paymentReport(){
        if(auth()->user()->role == 'admin'){
            $data = PlotAndUnit::paginate(30);
        }else{
            $data = PlotAndUnit::where('unique_id', auth()->user()->uid)->paginate(30);
        }
        return view('members.payment_report', compact('data'));
    }

}
