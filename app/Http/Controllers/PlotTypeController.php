<?php

namespace App\Http\Controllers;

use App\Models\PlotType;
use Illuminate\Http\Request;

class PlotTypeController extends Controller
{
    public function index(){
        $plot_types = PlotType::orderBy('id', 'desc')->get();
        return view('admin.plot_types.index',compact('plot_types'));
    }

    public function create(){
        return view('admin.plot_types.create');
    }

    public function store(Request $request){
        $plot_type = new PlotType();
        $plot_type->name    = $request->name;
        $plot_type->amount  = $request->amount;
        $plot_type->status  = $request->status;
        $plot_type->save();
        return redirect()->route('admin.type.index')->with('success','Data Added Successfully');
    }

    public function edit($id){

        $plot_type = PlotType::where('id', $id)->first();
        return view('admin.plot_types.edit',compact('plot_type'));
    }

    public function update(Request $request, $id){

        $plot_type = PlotType::where('id', $id)->first();
        $plot_type->name    = $request->name;
        $plot_type->amount  = $request->amount;
        $plot_type->status  = $request->status;
        $plot_type->save();

        return redirect()->route('admin.type.index')->with('success','Data Updated Successfully');
    }

    public function destroy($id){

        $plot_type = PlotType::where('id', $id)->first()->delete();
        return redirect()->route('admin.type.index')->with('success','Data Deleted Successfully');
    }

}
