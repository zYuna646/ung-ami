<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStandardRequest;
use App\Http\Requests\UpdateStandardRequest;
use App\Models\Standard;

class StandardController extends Controller
{
    public function index()
    {
        $standards = Standard::get();

        return view('pages.dashboard.master.standards.index', compact('standards'));
    }

    public function create()
    {
        return view('pages.dashboard.master.standards.create');
    }

    public function store(StoreStandardRequest $request)
    {
        try {
            $data = $request->validated();
            Standard::create($data);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.']);
        }
    }

    public function edit(Standard $standard)
    {
        return view('pages.dashboard.master.standards.edit', compact('standard'));
    }

    public function update(UpdateStandardRequest $request, Standard $standard)
    {
        try {
            $data = $request->validated();
            $standard->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.']);
        }
    }

    public function destroy(Standard $standard)
    {
        try {
            $standard->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
