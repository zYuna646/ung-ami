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
    public function store(StoreIndicatorRequest $request, Periode $periode, Instrument $instrument)
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

    public function update(UpdateIndicatorRequest $request, Periode $periode, Instrument $instrument, Indicator $indicator)
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

    public function destroy(Periode $periode, Instrument $instrument, Indicator $indicator)
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
