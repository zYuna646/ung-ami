<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeriodeRequest;
use App\Http\Requests\UpdatePeriodeRequest;
use App\Models\Auditor;
use App\Models\MasterInstrument;
use App\Models\Periode;
use App\Models\Program;
use App\Models\Standard;
use App\Models\Team;
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
        $teams = Team::get();

        return view('pages.dashboard.master.periodes.create', compact('standards', 'teams'));
    }

    public function store(StorePeriodeRequest $request)
    {
        try {
            $data = $request->validated();
            $periode = Periode::create($data);

            return redirect()->route('dashboard.master.periodes.show', $periode->uuid)->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function show(Periode $periode)
    {
        $auditors = Auditor::all();
        $units = Unit::get();
        $masterInstruments = MasterInstrument::get();

        $programs = Program::all()->map(function ($program) {
            return [
                'program' => $program,
                'ptp' => $program->PTPs->count(),
                'kts' => $program->noncomplianceResults()->where('category', 'KTS')->count(),
                'obs' => $program->noncomplianceResults()->where('category', 'OBS')->count(),
                'score' => $program->PTPs->count() - $program->noncomplianceResults()->where('category', 'OBS')->count(),
            ];
        })->sortByDesc('score')->values(); // Mengurutkan berdasarkan (PTP - OBS) secara descending

        return view('pages.dashboard.master.periodes.show', compact('periode', 'units', 'masterInstruments', 'programs'));
    }

    
    public function edit(Periode $periode)
    {
        $standards = Standard::get();
        $auditors = Auditor::all();
        $teams = Team::get();


        return view('pages.dashboard.master.periodes.edit', compact('periode', 'standards', 'teams'));
    }

    public function update(UpdatePeriodeRequest $request, Periode $periode)
    {
        try {
            $data = $request->validated();
            $periode->update($data);

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

    public function addMember(Request $request, Periode $periode)
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

    public function deleteMember(Periode $periode, Auditor $auditor)
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
