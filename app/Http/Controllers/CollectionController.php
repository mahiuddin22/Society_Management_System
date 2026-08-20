<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Settings;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $member_id          = $request->member_id;
        $filter_data        = $request->filter_data;
        $filter_status      = $request->filter_status;
        $filter_holding_no  = $request->filter_holding_no;
        $filter_road        = $request->filter_road;

        $data = Member::with('plot')->orderBy('id', 'desc');

        if (!empty($filter_data)) {
            $data->where(function ($query) use ($filter_data) {
                $query->where('name', 'LIKE', '%' . $filter_data . '%')
                    ->orWhere('number', $filter_data)
                    ->orWhere('email', $filter_data)
                    ->orWhere('amount', $filter_data);
            });
        }

        if (!empty($member_id)) {
            $data->where('unique_id',$member_id);
        }

        if (!empty($filter_holding_no)) {
            $data->where('holding_no', 'LIKE', '%' . $filter_holding_no . '%');
        }

        if (!empty($filter_road)) {
            $data->where('road', 'LIKE', '%' . $filter_road . '%');
        }

        if ($filter_status !== null && $filter_status !== '') {
            $data->where('payment_status', $filter_status);
        }

        $data = $data->paginate(30);

        return view('admin.collections.index', compact('data'));
    }

    public function receipt($id)
    {
        $member = Member::with('plot')->findOrFail($id);
        $settings = Settings::latest()->first();
        return view('admin.collections.receipt', compact('member','settings'));
    }

    // public function create()
    // {
    //     return view('admin.collections.create');
    // }

    // public function store(Request $request)
    // {
    //     $data = new Member();
    //     $data->name              = $request->name;
    //     $data->number           = $request->number;
    //     $data->email             = $request->email;
    //     $data->amount            = $request->amount;
    //     $data->payment_status    = $request->payment_status;
    //     $data->save();
    //     return redirect()->route('admin.collection.index')->with('success', 'Data Added Successfully');
    // }

    public function edit($id)
    {
        $data = Member::where('id', $id)->first();
        return view('admin.collections.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Member::findOrFail($id);
        $data->name             = $request->name;
        $data->number           = $request->number;
        $data->email            = $request->email;
        $data->amount           = $request->amount;
        $data->payment_status   = $request->payment_status;
        $data->save();

        return redirect()->route('admin.collection.index')->with('success', 'Data Updated Successfully');
    }

    public function changeStatus($id)
    {
        $data = Member::findOrFail($id);
        if ($data->payment_status == 0) {
            $data->payment_status = 1;
        } else {
            $data->payment_status = 0;
        }
        $data->save();

        return redirect()->back()->with('success', 'Status Changed Successfully');
    }

    public function destroy($id)
    {
        Member::findOrFail($id)->delete();
        return redirect()->route('admin.collection.index')->with('success', 'Data Deleted Successfully');
    }
}
