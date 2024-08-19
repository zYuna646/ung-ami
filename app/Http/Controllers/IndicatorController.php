<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIndicatorRequest;
use App\Http\Requests\UpdateIndicatorRequest;
use App\Models\Indicator;
use App\Models\Instrument;
use App\Models\Periode;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    public function index(Request $request)
    {
        $periodes = Periode::get();
        $instruments = Instrument::get();
        $indicators = Indicator::get();

        if (!$request->has('periode_id')) {
            $latestPeriode = Periode::latest()->first();
            $latestInstrument = Instrument::where('periode_id', $latestPeriode->id)->latest()->first();
    
            return redirect()->route('dashboard.master.indicators.index', [
                'periode_id' => $latestPeriode->id,
                'instrument_id' => $latestInstrument->id ?? null,
            ]);
        }

        return view('pages.dashboard.master.indicators.index', compact('indicators', 'instruments', 'periodes'));
    }

    public function store(StoreIndicatorRequest $request)
    {
        try {
            $data = $request->validated();
            Indicator::create($data);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function show(Indicator $indicator)
    {
        return view('pages.dashboard.master.indicators.show', compact('indicator'));
    }

    public function update(UpdateIndicatorRequest $request, Indicator $indicator)
    {
        try {
            $data = $request->validated();
            $indicator->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Indicator $indicator)
    {
        try {
            $indicator->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
