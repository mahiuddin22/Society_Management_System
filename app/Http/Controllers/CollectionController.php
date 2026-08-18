<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $data = Member::orderBy('id', 'desc')->get();
        return view('admin.collections.index', compact('data'));
    }

    public function create()
    {
        return view('admin.collections.create');
    }

    public function store(Request $request)
    {
        $data = new Member();
        $data->name    = $request->name;
        $data->amount  = $request->amount;
        $data->status  = $request->status;
        $data->save();
        return redirect()->route('admin.type.index')->with('success', 'Data Added Successfully');
    }

    public function edit($id)
    {

        $data = Member::where('id', $id)->first();
        return view('admin.collections.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {

        $data = Member::where('id', $id)->first();
        $data->name    = $request->name;
        $data->amount  = $request->amount;
        $data->status  = $request->status;
        $data->save();

        return redirect()->route('admin.type.index')->with('success', 'Data Updated Successfully');
    }

    public function destroy($id)
    {

        $data = Member::where('id', $id)->first()->delete();
        return redirect()->route('admin.type.index')->with('success', 'Data Deleted Successfully');
    }
}
