<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Indicator;
use App\Models\Instrument;
use App\Models\Periode;
use App\Models\Question;

class QuestionController extends Controller
{
    public function store(StoreQuestionRequest $request)
    {
        try {
            $data = $request->validated();
            $question = Question::create($data);
            $question->units()->attach($request->units);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function edit(Periode $periode, Instrument $instrument, Indicator $indicator, Question $question)
    {
        return view('pages.dashboard.master.periodes.questions-edit', compact('periode', 'instrument', 'indicator', 'question'));
    }

    public function update(UpdateQuestionRequest $request, Periode $periode, Instrument $instrument, Indicator $indicator, Question $question)
    {
        try {
            $data = $request->validated();
            $question->update($data);
            $question->units()->sync($request->units);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Periode $periode, Instrument $instrument, Indicator $indicator, Question $question)
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
