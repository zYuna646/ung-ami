<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasterIndicatorRequest;
use App\Http\Requests\UpdateMasterIndicatorRequest;
use App\Models\MasterIndicator;

class MasterIndicatorController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MasterIndicator::class, 'indicator');
    }

    public function store(StoreMasterIndicatorRequest $request)
    {
        try {
            $data = $request->validated();
            MasterIndicator::create($data);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function update(UpdateMasterIndicatorRequest $request, MasterIndicator $indicator)
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

    public function destroy(MasterIndicator $indicator)
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
