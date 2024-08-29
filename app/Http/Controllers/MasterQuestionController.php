<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasterQuestionRequest;
use App\Http\Requests\UpdateMasterQuestionRequest;
use App\Models\MasterQuestion;

class MasterQuestionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MasterQuestion::class, 'question');
    }

    public function store(StoreMasterQuestionRequest $request)
    {
        try {
            $data = $request->validated();
            MasterQuestion::create($data);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function update(UpdateMasterQuestionRequest $request, MasterQuestion $question)
    {
        try {
            $data = $request->validated();
            $question->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(MasterQuestion $question)
    {
        try {
            $question->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }
}
