<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstrumentRequest;
use App\Http\Requests\UpdateInstrumentRequest;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Indicator;
use App\Models\Instrument;
use App\Models\InstrumentEntityTeam;
use App\Models\MasterInstrument;
use App\Models\Periode;
use App\Models\Program;
use App\Models\Question;
use App\Models\Team;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    public function store(StoreInstrumentRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $masterInstrument = MasterInstrument::findOrFail($data['master_instrument_id']);
            $instrument = Instrument::create([
                'name' => $masterInstrument->instrument,
                'periode_id' => $data['periode_id']
            ]);
            $instrument->units()->attach($data['units']);
            foreach ($masterInstrument->indicators as $masterIndicator) {
                $indicator = Indicator::create([
                    'name' => $masterIndicator->indicator,
                    'instrument_id' => $instrument->id
                ]);
                foreach ($masterIndicator->questions as $masterQuestion) {
                    $questions = Question::create([
                        'code' => $masterQuestion->code,
                        'text' => $masterQuestion->question,
                        'indicator_id' => $indicator->id
                    ]);
                    $questions->units()->attach($data['units']);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.')->withFragment('add-instrument');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function show(Request $request, Periode $periode, Instrument $instrument)
    {
        $questions = [];
        $indicator = null;
        $areas = $instrument->units
            ->concat($instrument->faculties)
            ->concat($instrument->programs)
            ->filter(function ($item) {
                return $item->user !== null;
            })
            ->map(function ($item) {
                return $item->setAttribute('model_type', class_basename($item));
            })
            ->values();
        if ($request->has('indicator')) {
            $indicator = Indicator::where('uuid', $request->indicator)->first();
            $questions = $indicator->questions ?? [];
        }
        $teams = Team::latest()->get();

        return view('pages.dashboard.master.periodes.instrument-show', compact('periode', 'instrument', 'indicator', 'questions', 'areas', 'teams'));
    }

    public function edit(Periode $periode, Instrument $instrument)
    {
        $units = Unit::get();
        $faculties = Faculty::get();
        $departments = Department::get();
        $programs = Program::get();

        return view('pages.dashboard.master.periodes.instrument-edit', compact('periode', 'instrument', 'units', 'faculties', 'departments', 'programs'));
    }

    public function update(UpdateInstrumentRequest $request, Periode $periode,  Instrument $instrument)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $instrument->update($data);
            $instrument->units()->sync($data['units']);
            if ($request->has('faculties')) {
                $instrument->faculties()->sync($data['faculties']);
            }
            if ($request->has('departments')) {
                $instrument->departments()->sync($data['departments']);
            }
            if ($request->has('programs')) {
                $instrument->programs()->sync($data['programs']);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Periode $periode, Instrument $instrument)
    {
        try {
            $instrument->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function updateArea(Request $request, Periode $periode, Instrument $instrument)
    {
        // Validate the request
        $request->validate([
            'model_type' => 'required|string',
            'id' => 'required|integer',
            'team_id' => 'required|exists:teams,id',
        ]);

        // Determine the model type and update the pivot table
        $modelClass = 'App\\Models\\' . $request->input('model_type');
        if (!class_exists($modelClass)) {
            abort(404, 'Model type not found');
        }

        $entityId = $request->input('id');
        $teamId = $request->input('team_id');

        // Update or create the record in the pivot table
        InstrumentEntityTeam::updateOrCreate(
            [
                'instrument_id' => $instrument->id,
                'entity_id' => $entityId,
                'entity_type' => class_basename($modelClass),
            ],
            ['team_id' => $teamId]
        );

        // Redirect or return a response
        return redirect()->route('dashboard.master.periodes.instruments.show', [$periode->uuid, $instrument->uuid])
            ->with('success', 'Area updated successfully');
    }
}
