<?php

namespace App\Http\Controllers;

use App\Imports\MembersImport;
use App\Models\Member;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{

    public function index(Request $request)
    {
        $filter_data = $request->filter_data;

        $data = Member::orderBy('id', 'desc');

        if (!empty($filter_data)) {
            $data->where(function ($query) use ($filter_data) {
                $query->where('name', 'LIKE', '%' . $filter_data . '%')
                    ->orWhere('number', $filter_data)
                    ->orWhere('email', $filter_data)
                    ->orWhere('flat_no', $filter_data);
            });
        }

        $data = $data->paginate(30);
        return view('admin.members.index', compact('data'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $data = new Member();
        $data->name    = $request->name;
        $data->flat_no = $request->flat_no;
        $data->number  = $request->number;
        $data->email   = $request->email;
        $data->save();
        return redirect()->route('admin.members.index')->with('success', 'Data Added Successfully');
    }

    public function edit($id)
    {
        $data = Member::where('id', $id)->first();
        return view('admin.members.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Member::findOrFail($id);
        $data->name    = $request->name;
        $data->flat_no = $request->flat_no;
        $data->number  = $request->number;
        $data->email   = $request->email;
        $data->save();

        return redirect()->route('admin.members.index')->with('success', 'Data Updated Successfully');
    }

    public function destroy($id)
    {
        $data = Member::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.members.index')->with('success', 'Data Deleted Successfully');
    }
}
