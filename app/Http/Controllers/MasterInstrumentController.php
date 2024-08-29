<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasterInstrumentRequest;
use App\Http\Requests\UpdateMasterInstrumentRequest;
use App\Models\MasterIndicator;
use App\Models\MasterInstrument;
use Illuminate\Http\Request;

class MasterInstrumentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MasterInstrument::class, 'instrument');
    }

    public function index()
    {
        $instruments = MasterInstrument::get();

        return view('pages.dashboard.master.instruments.index', compact('instruments'));
    }

    public function store(StoreMasterInstrumentRequest $request)
    {
        try {
            $data = $request->validated();
            MasterInstrument::create($data);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function show(Request $request, MasterInstrument $instrument)
    {
        $questions = [];
        $indicator = null;

        if ($request->has('indicator')) {
            $indicator = MasterIndicator::where('uuid', $request->indicator)->first();
            $questions = $indicator->questions ?? [];
        }

        return view('pages.dashboard.master.instruments.show', compact('instrument', 'questions', 'indicator'));
    }

    public function update(UpdateMasterInstrumentRequest $request, MasterInstrument $instrument)
    {
        try {
            $data = $request->validated();
            $instrument->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(MasterInstrument $instrument)
    {
        try {
            $instrument->delete();

            return redirect()->route('dashboard.master.instruments.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
