<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Auditor;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Team::class, 'team');
    }

    public function index()
    {
        $teams = Team::latest()->get();

        return view('pages.dashboard.users.teams.index', compact('teams'));
    }

    public function create(Request $request)
    {
        $auditors = Auditor::all();
        $selectedAuditor = Auditor::find($request->auditor);

        $availableToBeMember = $selectedAuditor ? $auditors->reject(function ($auditor) use ($selectedAuditor) {
            return $auditor->is($selectedAuditor);
        })->values() : null;

        return view('pages.dashboard.users.teams.create', compact('auditors', 'availableToBeMember'));
    }

    public function store(StoreTeamRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $instrument = Team::create($data);
            $instrument->members()->attach($data['members']);
            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function edit(Request $request, Team $team)
    {
        $auditors = Auditor::all();
        $availableToBeMember = $auditors->reject(function ($auditor) use ($team) {
            return $auditor->is($team->chief);
        })->values();

        return view('pages.dashboard.users.teams.edit', compact('team', 'auditors', 'availableToBeMember'));
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        try {
            $data = $request->validated();

            if ($data['chief_auditor_id'] != $team->chief_auditor_id) {
                // Remove chief_auditor_id from members array if present
                $data['members'] = array_filter($data['members'], fn($member) => $member != $data['chief_auditor_id']);

                // Update the team's chief_auditor_id
                $team->chief_auditor_id = $data['chief_auditor_id'];
                $team->update();
            }

            // Sync the team members
            $team->members()->sync($data['members']);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Team $team)
    {
        try {
            $team->delete();

            return redirect()->route('dashboard.users.teams.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
