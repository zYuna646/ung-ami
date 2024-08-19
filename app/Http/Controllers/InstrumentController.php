<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstrumentRequest;
use App\Http\Requests\UpdateInstrumentRequest;
use App\Models\Instrument;

class InstrumentController extends Controller
{
    public function index()
    {
        $instruments = Instrument::get();

        return view('pages.dashboard.master.instruments.index', compact('instrumentts'));
    }

    public function create()
    {
        return view('pages.dashboard.master.instruments.create');
    }

    public function store(StoreInstrumentRequest $request)
    {
        try {
            $data = $request->validated();
            Instrument::create($data);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.')->withFragment('add-instrument');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function show(Instrument $instrument)
    {
        return view('pages.dashboard.master.instruments.show', compact('instrument'));
    }

    public function update(UpdateInstrumentRequest $request, Instrument $instrument)
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

    public function destroy(Instrument $instrument)
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
