<?php

namespace App\Http\Controllers;

use App\Models\PlotAndUnit;
use Illuminate\Http\Request;

class PlotAndUnitController extends Controller
{
    public function index()
    {
        $plotAndUnits = PlotAndUnit::all();
        return view('admin.plot_and_units.index', compact('plotAndUnits'));
    }
    
    public function create()
    {
        return view('admin.plot_and_units.create');
    }
}
