<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstrumentRequest;
use App\Http\Requests\UpdateInstrumentRequest;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Indicator;
use App\Models\Instrument;
use App\Models\MasterInstrument;
use App\Models\Periode;
use App\Models\Program;
use App\Models\Question;
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

        if ($request->has('indicator')) {
            $indicator = Indicator::where('uuid', $request->indicator)->first();
            $questions = $indicator->questions ?? [];
        }

        return view('pages.dashboard.master.periodes.instrument-show', compact('periode', 'instrument', 'indicator', 'questions'));
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
}
