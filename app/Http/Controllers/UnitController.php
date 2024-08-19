<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Unit::class, 'unit');
    }

    public function index()
    {
        $units = Unit::latest()->get();

        return view('pages.dashboard.master.units.index', compact('units'));
    }

    public function create()
    {
        return view('pages.dashboard.master.units.create');
    }

    public function store(StoreUnitRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $user = User::create([
                'name' => "Kepala {$request->unit_name}",
                'email' => strtolower(str_replace(' ', '_', $request->unit_name)) . '@amiung.com',
                'password' => Hash::make(Str::random(12))
            ]);
            $data['user_id'] = $user->id;
            Unit::create($data);

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function edit(Unit $unit)
    {
        return view('pages.dashboard.master.units.edit', compact('unit'));
    }

    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        try {
            $data = $request->validated();
            $unit->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();

            return redirect()->route('dashboard.master.units.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
