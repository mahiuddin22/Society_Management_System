<?php

namespace App\Http\Controllers;

use App\Models\MissingFlat;
use App\Models\PlotAndUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MissingFlatController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->visiblePlots()->with(['road', 'missingFlats'])
            ->whereRaw('COALESCE(total_flat, 0) > COALESCE(occupied_flat, 0)');
        if ($request->filled('road_id')) {
            $query->where('road_id', $request->integer('road_id'));
        }
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(fn ($q) => $q->where('holding_no', 'like', "%{$search}%")
                ->orWhere('building_name', 'like', "%{$search}%"));
        }
        $plots = $query->orderBy('road_id')->orderBy('holding_no')->paginate(30)->withQueryString();
        $roads = $this->visiblePlots()->with('road')->get()->pluck('road')->filter()->unique('id')->sortBy('number');

        return view('admin.missing_flats.index', compact('plots', 'roads'));
    }

    public function create(Request $request)
    {
        $plots = $this->visiblePlots()->with(['road', 'missingFlats'])
            ->whereRaw('COALESCE(total_flat, 0) > COALESCE(occupied_flat, 0)')
            ->orderBy('road_id')->orderBy('holding_no')->get();

        return view('admin.missing_flats.create', [
            'plots' => $plots,
            'selectedPlotId' => $request->query('plot'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plot_and_unit_id' => ['required', 'integer', 'exists:plot_and_units,id'],
            'flat_numbers' => ['required', 'array', 'min:1'],
            'flat_numbers.*' => ['required', 'string', 'max:30'],
            'missing_flat_note' => ['nullable', 'string', 'max:5000'],
        ]);

        $flatNumbers = collect($validated['flat_numbers'])
            ->map(fn ($number) => strtoupper(trim($number)))
            ->filter()->unique()->values();

        if ($flatNumbers->isEmpty()) {
            throw ValidationException::withMessages(['flat_numbers' => 'Add at least one flat number.']);
        }

        DB::transaction(function () use ($validated, $flatNumbers) {
            $plot = $this->visiblePlots()->whereKey($validated['plot_and_unit_id'])->lockForUpdate()->firstOrFail();
            $missingCount = max(0, (int) $plot->total_flat - (int) $plot->occupied_flat);
            $existing = MissingFlat::where('plot_and_unit_id', $plot->id)->pluck('flat_number');
            $availableToRegister = max(0, $missingCount - $existing->count());

            if ($flatNumbers->count() > $availableToRegister) {
                throw ValidationException::withMessages([
                    'flat_numbers' => "This plot has room to register {$availableToRegister} more missing flat number(s).",
                ]);
            }

            $duplicates = $flatNumbers->intersect($existing->map(fn ($number) => strtoupper($number)));
            if ($duplicates->isNotEmpty()) {
                throw ValidationException::withMessages([
                    'flat_numbers' => 'Already registered: '.$duplicates->implode(', '),
                ]);
            }

            foreach ($flatNumbers as $flatNumber) {
                MissingFlat::create([
                    'plot_and_unit_id' => $plot->id,
                    'flat_number' => $flatNumber,
                    'note' => $validated['missing_flat_note'] ?? null,
                ]);
            }
        });

        return redirect()->route('admin.missing-flats.index')->with('success', 'Missing flat numbers added successfully.');
    }

    public function edit(PlotAndUnit $plot)
    {
        abort_unless($this->visiblePlots()->whereKey($plot->id)->exists(), 404);
        $plot->load(['road', 'missingFlats']);
        return view('admin.missing_flats.create', [
            'plots' => collect([$plot]),
            'selectedPlotId' => $plot->id,
            'editing' => true,
        ]);
    }

    public function update(Request $request, PlotAndUnit $plot)
    {
        abort_unless($this->visiblePlots()->whereKey($plot->id)->exists(), 404);
        $validated = $request->validate([
            'flat_numbers' => ['nullable', 'array'],
            'flat_numbers.*' => ['required', 'string', 'max:30'],
            'missing_flat_note' => ['nullable', 'string', 'max:5000'],
        ]);
        $flatNumbers = collect($validated['flat_numbers'] ?? [])->map(fn ($n) => strtoupper(trim($n)))->filter()->unique()->values();

        DB::transaction(function () use ($plot, $flatNumbers, $validated) {
            $lockedPlot = $this->visiblePlots()->whereKey($plot->id)->lockForUpdate()->firstOrFail();
            $missingCount = max(0, (int) $lockedPlot->total_flat - (int) $lockedPlot->occupied_flat);
            if ($flatNumbers->count() > $missingCount) {
                throw ValidationException::withMessages(['flat_numbers' => "This plot has only {$missingCount} missing flat(s)."]);
            }
            MissingFlat::where('plot_and_unit_id', $lockedPlot->id)->delete();
            foreach ($flatNumbers as $flatNumber) {
                MissingFlat::create([
                    'plot_and_unit_id' => $lockedPlot->id,
                    'flat_number' => $flatNumber,
                    'note' => $validated['missing_flat_note'] ?? null,
                ]);
            }
        });

        return redirect()->route('admin.missing-flats.index')->with('success', 'Missing flat units updated successfully.');
    }

    private function visiblePlots()
    {
        $query = PlotAndUnit::query();

        if (auth()->user()?->role === 'collector') {
            $query->whereHas('road', fn ($roadQuery) => $roadQuery->where('collector_id', auth()->id()));
        }

        return $query;
    }
}
