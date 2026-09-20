<?php

namespace App\Http\Controllers;

use App\Imports\MembersImport;
use App\Models\PlotAndUnit;
use App\Models\Member;
use App\Models\PlotType;
use App\Models\Road;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

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
        $plot_types = PlotType::whereStatus('Active')->get(['id', 'name']);
        $rates      = $plot_types->pluck('amount', 'id')->toArray();
        $roads      = Road::get();
        return view('admin.plot_and_units.create', compact('plot_types', 'rates', 'roads'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'road'              => 'required',
            'holding_no'        => 'required|string|max:255',
            'building_type'     => 'required',
            'total_flat'        => 'nullable|integer|min:0',
            'occupied_flat'     => 'nullable|integer|min:0|lte:total_flat',
            'building_name'     => 'nullable|string',
            'collection_type'   => 'nullable',
            'collection_rate'   => 'required_if:building_type,9|nullable|numeric|min:0',
            'collection_amount' => 'required_if:building_type,9|nullable|numeric|min:0',
            'discount'          => 'nullable|numeric|min:0',
            'name'              => 'nullable',
            'flat_no'           => 'nullable|max:255',
            'number'            => 'nullable|string|max:255',
            'email'             => 'nullable|email|max:255',
            'date'              => 'required|date',
            'status'            => 'required|in:0,1',
        ]);

        $plotAndUnit                    = new PlotAndUnit();
        $plotAndUnit->road              = $validatedData['road'];
        $plotAndUnit->holding_no        = $validatedData['holding_no'];
        $plotAndUnit->building_type     = $validatedData['building_type'];
        $plotAndUnit->total_flat        = $validatedData['total_flat'] ?? 0;
        $plotAndUnit->occupied_flat     = $validatedData['occupied_flat'] ?? 0;
        $plotAndUnit->building_name     = $validatedData['building_name'] ?? 'N/A';
        $plotAndUnit->collection_type   = $validatedData['collection_type'];
        $plotAndUnit->name              = $validatedData['name'];
        $plotAndUnit->flat_no           = $validatedData['flat_no'];
        $plotAndUnit->collection_rate   = $validatedData['collection_rate'] ?? 0;
        $plotAndUnit->discount          = $validatedData['discount'] ?? 0;
        $plotAndUnit->collection_amount = $validatedData['collection_amount'] ?? 0;
        $plotAndUnit->date              = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d') ?? null;
        $plotAndUnit->status            = $validatedData['status'];

        if ($request->date) {
            $issue_date = Carbon::createFromFormat('d-m-Y', $request->date)->format('F Y');
        }

        // Normalize phone number
        $number = preg_replace('/\s+/', '', $validatedData['number']);

        if (!str_starts_with($number, '88')) {
            $number = '88' . $number;
        }

        $plotAndUnit->number = $number;
        $plotAndUnit->email  = $validatedData['email'] ?? null;
        $plotAndUnit->save();

        $plotAndUnit->unique_id = 'UT03'
            . $validatedData['road']
            . $validatedData['holding_no']
            . $plotAndUnit->id
            . $validatedData['total_flat'];

        $plotAndUnit->save();

        User::updateOrCreate(
            ['phone' => $number],
            [
                'role' => 7,
                'name' => $validatedData['name'],
                'username' => strtolower(preg_replace('/\s+/', '', $validatedData['name'])),
                'email' => $validatedData['email'],
                'phone' => $number,
                'uid' => 'UT03' . $validatedData['road'] . $validatedData['holding_no'] . $plotAndUnit->id . $validatedData['total_flat']
            ]
        );
        return redirect()->route('admin.plot-and-units.index')->with('success', 'Data created successfully.');
    }

    public function edit($id)
    {
        $data           = PlotAndUnit::where('id',$id)->first();
        $plot_types     = PlotType::where('status', true)->get();
        $rates          = $plot_types->pluck('amount', 'id')->toArray();
        $roads          = Road::all();
        return view('admin.plot_and_units.edit', compact('data', 'plot_types', 'rates', 'roads'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'road'              => 'required',
            'holding_no'        => 'required|string|max:255',
            'building_type'     => 'required',
            'total_flat'        => 'nullable|integer|min:0',
            'occupied_flat'     => 'nullable|integer|min:0|lte:total_flat',
            'building_name'     => 'nullable|string',
            'collection_type'   => 'nullable',
            'collection_rate'   => 'required_if:building_type,9|nullable|numeric|min:0',
            'collection_amount' => 'required_if:building_type,9|nullable|numeric|min:0',
            'discount'          => 'nullable|numeric|min:0',
            'name'              => 'nullable',
            'flat_no'           => 'nullable|max:255',
            'number'            => 'nullable|string|max:255',
            'email'             => 'nullable|email|max:255',
            'date'              => 'required|date',
            'status'            => 'required|in:0,1',
        ]);

        // Normalize phone number
        $number = preg_replace('/\s+/', '', $validatedData['number']);

        if (!str_starts_with($number, '88')) {
            $number = '88' . $number;
        }

        $plotAndUnit = PlotAndUnit::findOrFail($id);

        if ($plotAndUnit->building_type != $validatedData['building_type']) {

            // Create new PlotAndUnit
            $newplot = new PlotAndUnit();

            $newplot->road              = $validatedData['road'];
            $newplot->holding_no        = $validatedData['holding_no'];
            $newplot->building_type     = $validatedData['building_type'];
            $newplot->total_flat        = $validatedData['total_flat'] ?? 0;
            $newplot->occupied_flat     = $validatedData['occupied_flat'] ?? 0;
            $plotAndUnit->building_name = $validatedData['building_name'] ?? 'N/A';
            $newplot->collection_type   = $validatedData['collection_type'];
            $newplot->name              = $validatedData['name'];
            $newplot->flat_no           = $validatedData['flat_no'];
            $plotAndUnit->number        = $number;
            $plotAndUnit->email         = $validatedData['email'];
            $newplot->collection_rate   = $validatedData['collection_rate'] ?? 0;
            $newplot->discount          = $validatedData['discount'] ?? 0;
            $newplot->collection_amount = $validatedData['collection_amount'] ?? 0;
            $newplot->date              = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d') ?? null;
            $newplot->status            = $validatedData['status'];

            // Disable old PlotAndUnit
            $plotAndUnit->status = 0;
            $plotAndUnit->save();
            $newplot->save();

            // IMPORTANT:
            // From now on, use the new plot
            $plotAndUnit = $newplot;
            User::updateOrCreate(
                ['phone' => $number],
                [
                    'role'      => 'member',
                    'name'      => $validatedData['name'],
                    'username'  => strtolower(preg_replace('/\s+/', '', $validatedData['name'])),
                    'email'     => $validatedData['email'],
                    'phone'     => $number,
                    'uid'       => 'UT03' . $validatedData['road'] . $validatedData['holding_no'] . $plotAndUnit->id . $validatedData['total_flat'],
                    'password'     => Hash::make('123456'),
                ]
            );
        } else {

            // Update existing PlotAndUnit
            $plotAndUnit->road              = $validatedData['road'];
            $plotAndUnit->holding_no        = $validatedData['holding_no'];
            $plotAndUnit->building_type     = $validatedData['building_type'];
            $plotAndUnit->total_flat        = $validatedData['total_flat'] ?? 0;
            $plotAndUnit->occupied_flat     = $validatedData['occupied_flat'] ?? 0;
            $plotAndUnit->building_name     = $validatedData['building_name'] ?? 'N/A';
            $plotAndUnit->collection_type   = $validatedData['collection_type'];
            $plotAndUnit->name              = $validatedData['name'];
            $plotAndUnit->flat_no           = $validatedData['flat_no'];
            $plotAndUnit->number            = $number;
            $plotAndUnit->email             = $validatedData['email'];
            $plotAndUnit->collection_rate   = $validatedData['collection_rate'] ?? 0;
            $plotAndUnit->discount          = $validatedData['discount'] ?? 0;
            $plotAndUnit->collection_amount = $validatedData['collection_amount'] ?? 0;
            $plotAndUnit->date              = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d') ?? null;
            $plotAndUnit->status            = $validatedData['status'];
            $plotAndUnit->save();
            User::updateOrCreate(
                ['phone' => $number],
                [
                    'role'      => 'member',
                    'name'      => $validatedData['name'],
                    'username'  => strtolower(preg_replace('/\s+/', '', $validatedData['name'])),
                    'email'     => $validatedData['email'],
                    'phone'     => $number,
                    'uid'       => 'UT03' . $validatedData['road'] . $validatedData['holding_no'] . $plotAndUnit->id . $validatedData['total_flat'],
                    'password'     => Hash::make('123456'),
                ]
            );
        }

        return redirect()->route('admin.plot-and-units.index')->with('success', 'Data updated successfully.');
    }

    public function view($id)
    {
        $plotAndUnit = PlotAndUnit::findOrFail($id);
        return view('admin.plot_and_units.view', compact('plotAndUnit'));
    }

    public function destroy($id)
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
