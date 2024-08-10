<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstrumenRequest;
use App\Http\Requests\UpdateInstrumenRequest;
use App\Models\Auditor;
use App\Models\Instrumen;
use App\Models\Standar;
use App\Models\User;
use Illuminate\Http\Request;

class InstrumenController extends Controller
{
    public function index()
    {
        $instrumens = Instrumen::get();

        return view('pages.dashboard.master.instrumen.index', compact('instrumens'));
    }

    public function create()
    {
        $standars = Standar::get();
        $auditors = Auditor::get();

        return view('pages.dashboard.master.instrumen.create', compact('standars', 'auditors'));
    }

    public function store(StoreInstrumenRequest $request)
    {
        try {
            $data = $request->validated();
            Instrumen::create($data);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function show(Instrumen $instrumen)
    {
        return view('pages.dashboard.master.instrumen.show', compact('instrumen'));
    }

    public function edit(Instrumen $instrumen)
    {
        $standars = Standar::get();
        $auditors = Auditor::all();
        $availableToBeLeader = $auditors->reject(function ($auditor) use ($instrumen) {
            return $instrumen->anggota->contains($auditor);
        });
        $availableToBeMember = $auditors->reject(function ($auditor) use ($instrumen) {
            return $auditor->id === $instrumen->ketua_id;
        })->reject(function ($auditor) use ($instrumen) {
            return $instrumen->anggota->contains($auditor);
        });

        return view('pages.dashboard.master.instrumen.edit', compact('instrumen', 'standars', 'availableToBeLeader', 'availableToBeMember'));
    }

    public function update(UpdateInstrumenRequest $request, Instrumen $instrumen)
    {
        try {
            $data = $request->validated();
            $instrumen->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Instrumen $instrumen)
    {
        //
    }

    public function add_member(Request $request, Instrumen $instrumen)
    {
        try {
            // Validate the request data
            $request->validate([
                'auditor_id' => 'required|exists:auditors,id',
            ]);

            // Find the auditor
            $auditor = Auditor::findOrFail($request->auditor_id);

            // Check if the auditor is already a member of the given instrumen
            if ($instrumen->anggota->contains($auditor)) {
                return redirect()->back()->withErrors(['error' => 'Auditor telah menjadi anggota.']);
            }

            // Check if the auditor is already the leader of the same instrumen
            if ($auditor->id === $instrumen->ketua_id) {
                return redirect()->back()->withErrors(['error' => 'Auditor telah menjadi ketua.']);
            }

            // Add the auditor as a member
            $instrumen->anggota()->attach($auditor->id);

            return redirect()->back()->with('success', 'Anggota berhasil ditambahkan.');
        } catch (\Throwable $th) {
            // Log the error message and return a generic error message to the user
            logger()->error('Error adding member: ' . $th->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan anggota.'])->withInput();
        }
    }

    public function delete_member(Instrumen $instrumen, Auditor $auditor)
    {
        try {
            $isMember = $instrumen->anggota->contains($auditor);

            if (!$isMember) {
                return redirect()->back()->withErrors(['error' => 'Auditor bukan anggota dari instrumen ini.']);
            }

            $instrumen->anggota()->detach($auditor);

            return redirect()->back()->with('success', 'Anggota berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus anggota.'])->withInput();
        }
    }
}
