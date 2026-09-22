<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlotAndUnitRequest;
use App\Http\Requests\UpdatePlotAndUnitRequest;
use App\Imports\MembersImport;
use App\Models\PlotAndUnit;
use App\Models\Member;
use App\Models\PlotType;
use App\Models\Road;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class PlotAndUnitController extends Controller
{
    public function index(Request $request)
    {
        $holding_no      = $request->holding_no;
        $building_type   = $request->building_type;
        $collection_type = $request->collection_type;

        $plotAndUnits = PlotAndUnit::with(['road', 'plotType'])->orderBy('id', 'desc');

        if (!empty($holding_no)) {
            $plotAndUnits->where('holding_no', 'LIKE', '%' . $holding_no . '%');
        }

        if (!empty($building_type)) {
            $plotAndUnits->where('building_type', $building_type);
        }

        if (!empty($collection_type)) {
            $plotAndUnits->where('collection_type', $collection_type);
        }

        $plotAndUnits = $plotAndUnits->paginate(30);
        $plot_types = PlotType::where('status', true)->get();
        return view('admin.plot_and_units.index', compact('plotAndUnits', 'plot_types'));
    }

    public function create()
    {
        $plotTypes = PlotType::whereStatus('Active')->get(['id', 'name', 'slug', 'fees']);
        $rates      = $plotTypes->pluck('amount', 'id')->toArray();
        $roads      = Road::get();
        $pageTitle = '';
        return view('admin.plot_and_units.create', compact('plotTypes', 'rates', 'roads', 'pageTitle'));
    }

    public function store(StorePlotAndUnitRequest $request)
    {
        $validated = $request->validated();
        $road = Road::find($validated['road']);

        try {
            DB::transaction(function () use ($validated, $road) {
                PlotAndUnit::create([
                    'plot_type_id'    => $validated['plot_type'],
                    'road_id'         => $validated['road'],
                    'holding_no'      => $validated['holding_no'],
                    'building_name'   => $validated['building_name'] ?? null,
                    'total_flat'      => $validated['total_flat'] ?? 0,
                    'occupied_flat'   => $validated['occupied_flat'] ?? 0,
                    'flat_numbers'    => $validated['flat_numbers'] ?? null,
                    'collection_type' => $validated['collection_type'] ?? null,

                    // Contact Representative
                    'name'            => $validated['name'] ?? 'N/A',
                    'flat_no'         => $validated['flat_no'] ?? null,
                    'phone'           => $validated['phone'] ?? 'N/A',
                    'email'           => $validated['email'] ?? null,
                    'unique_id'       => 'UTR03'
                                        . '-'
                                        . $road->number
                                        . $validated['holding_no']
                                        . '-'
                                        . match (true) {
                                            ($validated['occupied_flat'] == 0 || $validated['occupied_flat'] == null) && $validated['plot_type'] == 2 => 'CONS',
                                            ($validated['occupied_flat'] == 0 || $validated['occupied_flat'] == null) && $validated['plot_type'] == 1 => 'LAND',
                                            default => $validated['flat_no'],
                                        },

                    // Financials
                    'collection_rate' => $validated['collection_rate'] ?? 0,
                    'discount'        => $validated['discount'] ?? 0,
                    'total_amount'    => $validated['collection_amount'] ?? 0,

                    'status'          => $validated['status'],
                ]);

                User::updateOrCreate(
                    ['phone' => $validated['phone']],
                    [
                        'role'  => 7,
                        'name'  => $validated['name'],
                        'email' => $validated['email'],
                        'password' => Hash::make(Str::random(10)),
                        'phone' => $validated['phone'],
                    ]
                );
            });
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.plot-and-units.index')->with('success', 'Data created successfully.');
    }

    public function edit(int $id)
    {
        $pageTitle = '';
        $plotAndUnit = PlotAndUnit::findOrFail($id);
        $plotTypes   = PlotType::where('status', 'Active')->get(['id', 'name', 'slug', 'fees']);
        $rates       = $plotTypes->pluck('fees', 'id')->toArray();
        $roads       = Road::all();

        return view('admin.plot_and_units.edit', compact('plotAndUnit', 'plotTypes', 'rates', 'roads', 'pageTitle'));
    }

    public function update(UpdatePlotAndUnitRequest $request, int $id)
    {
        
        #TODO::Some infomation can't update when payment cycle started.

        $validated = $request->validated();
        $plotAndUnit = PlotAndUnit::findOrFail($id);
        $road = Road::find($validated['road']);

        try {
            DB::transaction(function () use ($validated, $plotAndUnit, $road) {
                $plotAndUnit->update([
                    'plot_type_id'    => $validated['plot_type'],
                    'road_id'         => $validated['road'],
                    'holding_no'      => $validated['holding_no'],
                    'building_name'   => $validated['building_name'] ?? null,
                    'total_flat'      => $validated['total_flat'] ?? 0,
                    'occupied_flat'   => $validated['occupied_flat'] ?? 0,
                    'flat_numbers'    => $validated['flat_numbers'] ?? null,
                    'collection_type' => $validated['collection_type'] ?? null,

                    // Contact Representative
                    'name'            => $validated['name'],
                    'flat_no'         => $validated['flat_no'] ?? null,
                    'phone'           => $validated['phone'],
                    'email'           => $validated['email'] ?? null,

                    'unique_id'       => 'UTR03'
                                        . '-'
                                        . $road->number
                                        . $validated['holding_no']
                                        . '-'
                                        . match (true) {
                                            ($validated['occupied_flat'] == 0 || $validated['occupied_flat'] == null) && $validated['plot_type'] == 2 => 'CONS',
                                            ($validated['occupied_flat'] == 0 || $validated['occupied_flat'] == null) && $validated['plot_type'] == 1 => 'LAND',
                                            default => $validated['flat_no'],
                                        },

                    // Financials
                    'collection_rate' => $validated['collection_rate'] ?? 0,
                    'discount'        => $validated['discount'] ?? 0,
                    'total_amount'    => $validated['collection_amount'] ?? 0,
                    'status'          => $validated['status'],
                ]);

                // Sync User record
                User::updateOrCreate(
                    ['phone' => $validated['phone']],
                    [
                        'role'  => 7,
                        'name'  => $validated['name'],
                        'email' => $validated['email'] ?? null,
                    ]
                );
            });
        } catch (\Throwable $e) {
            report($e);
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.plot-and-units.show', $id)->with('success', 'Building updated successfully.');
    }

    public function view(int $id)
    {
        $plotAndUnit = PlotAndUnit::with(['road', 'plotType'])->findOrFail($id);
        return view('admin.plot_and_units.view', compact('plotAndUnit'));
    }

    public function destroy(int $id)
    {
        $plotAndUnit = PlotAndUnit::findOrFail($id);
        $plotAndUnit->sector_collenctions()->delete();
        $plotAndUnit->delete();
        return redirect()->route('admin.plot-and-units.index')->with('success', 'Data deleted successfully.');
    }

    public function bulkUpload()
    {
        return view('admin.plot_and_units.bulk-upload');
    }

    public function bulkUploadStore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $file = $request->file('file');
        $directory = storage_path('app/imports');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move($directory, $fileName);

        Excel::import(new MembersImport(), $directory . DIRECTORY_SEPARATOR . $fileName);
        return redirect()->back()->with('success', 'Members uploaded successfully.');
    }
}
