<?php

namespace App\Http\Controllers;

use App\Models\PlotType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlotTypeController extends Controller
{
    public function index(Request $request)
    {
        $name   = $request->name;
        $status = $request->filter_status;

        $plot_types = PlotType::orderBy('id', 'desc');

        if (!empty($name)) {
            $plot_types->where('name', 'LIKE', '%' . $name . '%');
        }

        if ($status !== null && $status !== '') {
            $plot_types->where('status', $status);
        }

        $plot_types = $plot_types->get();
        return view('admin.plot_types.index', compact('plot_types'));
    }

    public function create()
    {
        return view('admin.plot_types.create');
    }

    public function store(Request $request)
    {
        #TODO::Add validation
        $plot_type = new PlotType();
        $plot_type->name = $request->name;
        $plot_type->slug = Str::slug($request->name);
        $plot_type->fees = $request->fees;
        $plot_type->status  = $request->status;
        $plot_type->save();
        return redirect()->route('admin.plot_type.index')->with('success', 'Data Added Successfully');
    }

    public function edit($id)
    {
        $plot_type = PlotType::where('id', $id)->first();
        return view('admin.plot_types.edit', compact('plot_type'));
    }

    public function update(Request $request, $id)
    {
        #TODO::Add validation
        $plot_type = PlotType::where('id', $id)->first();
        $plot_type->name = $request->name;
        $plot_type->slug = Str::slug($request->name);
        $plot_type->fees = $request->fees;
        $plot_type->status = $request->status;
        $plot_type->save();

        return redirect()->route('admin.plot_type.index')->with('success', 'Data Updated Successfully');
    }

    public function changeStatus($id)
    {
        $data = PlotType::findOrFail($id);
        if ($data->status == 'Inactive') {
            $data->status = 'Active';
        } else {
            $data->status = 'Inactive';
        }
        $data->save();

        return redirect()->back()->with('success', 'Status Changed Successfully');
    }


    public function destroy($id)
    {
        #TODO::Check if any member is connected with type plot type
        PlotType::where('id', $id)->first()->delete();
        return redirect()->route('admin.plot_type.index')->with('success', 'Data Deleted Successfully');
    }
}
