<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStandarRequest;
use App\Http\Requests\UpdateStandarRequest;
use App\Models\Standar;

class StandarController extends Controller
{
    public function index()
    {
        $standars = Standar::get();

        return view('pages.dashboard.master.standar.index', compact('standars'));
    }

    public function create()
    {
        return view('pages.dashboard.master.standar.create');
    }

    public function store(StoreStandarRequest $request)
    {
        try {
            $data = $request->validated();
            Standar::create($data);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.']);
        }
    }

    public function show(Standar $standar)
    {
        //
    }

    public function edit(Standar $standar)
    {
        return view('pages.dashboard.master.standar.edit', compact('standar'));
    }

    public function update(UpdateStandarRequest $request, Standar $standar)
    {
        try {
            $data = $request->validated();
            $standar->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.']);
        }
    }

    public function destroy(Standar $standar)
    {
        //
    }
}
