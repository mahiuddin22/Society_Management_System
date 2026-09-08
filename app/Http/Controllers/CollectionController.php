<?php

namespace App\Http\Controllers;

use App\Models\Road;
use App\Models\SectorCollenctions;
use App\Models\Settings;
use Carbon\Carbon;
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

        $data = SectorCollenctions::orderBy('id', 'desc');

        if (auth()->user()->role == 'collector') {
            $roadIds = Road::where('collector_id', auth()->id())->pluck('id');

            $data->whereIn('road', $roadIds);
        }

        if (!empty($filter_data)) {
            $data->where(function ($query) use ($filter_data) {
                $query->where('name', 'LIKE', '%' . $filter_data . '%')->orWhere('number', $filter_data)
                    ->orWhere('email', $filter_data)->orWhere('amount', $filter_data);
            });
        }

        if (!empty($member_id)) {
            $data->where('unique_id', $member_id);
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
        $collection = SectorCollenctions::findOrFail($id);
        $settings   = Settings::latest()->first();
        return view('admin.collections.receipt', compact('collection', 'settings'));
    }

    // public function create()
    // {
    //     return view('admin.collections.create');
    // }

    // public function store(Request $request)
    // {
    //     $data = new SectorCollenctions();
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
        $data = SectorCollenctions::where('id', $id)->first();
        return view('admin.collections.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = SectorCollenctions::findOrFail($id);
        $data->name             = $request->name;
        $data->number           = $request->number;
        $data->email            = $request->email;
        $data->amount           = $request->amount;
        $data->payment_status   = $request->payment_status;
        $data->payment_date     = Carbon::createFromFormat('d-m-Y', $request->payment_date)->format('Y-m-d');
        $data->save();

        return redirect()->route('admin.collection.index')->with('success', 'Data Updated Successfully');
    }

    public function changeStatus($id)
    {
        $data = SectorCollenctions::findOrFail($id);
        if ($data->payment_status == 0) {
            $data->payment_status = 1;
            if (is_null($data->payment_date)) {
                $data->payment_date = now();
            }
        } else {
            $data->payment_status = 0;
        }
        $data->save();

        return redirect()->back()->with('success', 'Status Changed Successfully');
    }

    public function destroy($id)
    {
        SectorCollenctions::findOrFail($id)->delete();
        return redirect()->route('admin.collection.index')->with('success', 'Data Deleted Successfully');
    }
}
