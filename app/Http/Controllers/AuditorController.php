<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuditorRequest;
use App\Http\Requests\UpdateAuditorRequest;
use App\Models\Auditor;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuditorController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Auditor::class, 'auditor');
    }

    public function index()
    {
        $auditors = Auditor::latest()->get();

        return view('pages.dashboard.users.auditors.index', compact('auditors'));
    }

    public function create()
    {
        return view('pages.dashboard.users.auditors.create');
    }

    public function store(StoreAuditorRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $user = User::create($data);
            Auditor::create([
                'user_id' => $user->id
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function edit(Auditor $auditor)
    {
        return view('pages.dashboard.users.auditors.edit', compact('auditor'));
    }

    public function update(UpdateAuditorRequest $request, Auditor $auditor)
    {
        try {
            $data = $request->validated();
            $auditor->user->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Auditor $auditor)
    {
        DB::beginTransaction();

        try {
            $user = $auditor->user;
            $auditor->delete();
            if ($user) $user->delete();

            DB::commit();

            return redirect()->route('dashboard.users.auditors.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
