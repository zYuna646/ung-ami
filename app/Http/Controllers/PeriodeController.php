<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeriodeRequest;
use App\Http\Requests\UpdatePeriodeRequest;
use App\Models\Auditor;
use App\Models\Periode;
use App\Models\Standard;
use App\Models\Unit;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::get();

        return view('pages.dashboard.master.periodes.index', compact('periodes'));
    }

    public function create()
    {
        $standards = Standard::get();
        $units = Unit::get();
        $auditors = Auditor::get();

        return view('pages.dashboard.master.periodes.create', compact('standards', 'auditors', 'units'));
    }

    public function store(StorePeriodeRequest $request)
    {
        try {
            $data = $request->validated();
            $periode = Periode::create($data);
            $periode->units()->attach($request->units);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function show(Periode $periode)
    {
        $auditors = Auditor::all();
        $availableToBeMember = $auditors->reject(function ($auditor) use ($periode) {
            return $auditor->id === $periode->chief_auditor_id;
        })->reject(function ($auditor) use ($periode) {
            return $periode->auditor_members->contains($auditor);
        });

        return view('pages.dashboard.master.periodes.show', compact('periode', 'availableToBeMember'));
    }

    public function edit(Periode $periode)
    {
        $standards = Standard::get();
        $auditors = Auditor::all();
        $availableToBeChief = $auditors->reject(function ($auditor) use ($periode) {
            return $periode->auditor_members->contains($auditor);
        });
        $units = Unit::get();

        return view('pages.dashboard.master.periodes.edit', compact('periode', 'standards', 'availableToBeChief', 'units'));
    }

    public function update(UpdatePeriodeRequest $request, Periode $periode)
    {
        try {
            $data = $request->validated();
            $periode->update($data);
            $periode->units()->sync($request->units);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Periode $periode)
    {
        try {
            $periode->delete();

            return redirect()->route('dashboard.master.periodes.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function add_member(Request $request, Periode $periode)
    {
        try {
            $request->validate([
                'auditor_id' => 'required|exists:auditors,id',
            ]);

            $auditor = Auditor::findOrFail($request->auditor_id);

            if ($periode->auditor_members->contains($auditor)) {
                return redirect()->back()->withErrors(['error' => 'Auditor telah menjadi anggota.']);
            }

            if ($auditor->id == $periode->chief_auditor_id) {
                return redirect()->back()->withErrors(['error' => 'Auditor telah menjadi ketua.']);
            }

            $periode->auditor_members()->attach($auditor->id);

            return redirect()->back()->with('success', 'Anggota berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error('Error adding member: ' . $th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan anggota.'])->withInput();
        }
    }

    public function delete_member(Periode $periode, Auditor $auditor)
    {
        try {
            $isMember = $periode->auditor_members->contains($auditor);

            if (!$isMember) {
                return redirect()->back()->withErrors(['error' => 'Auditor bukan anggota.']);
            }

            $periode->auditor_members()->detach($auditor);

            return redirect()->back()->with('success', 'Anggota berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus anggota.'])->withInput();
        }
    }
}
