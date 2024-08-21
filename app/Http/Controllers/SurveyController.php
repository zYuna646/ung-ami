<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitSurveyRequest;
use App\Models\Instrument;
use App\Models\Periode;
use App\Models\SurveyResponse;
use App\Models\User;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAnySurvey', Instrument::class);

        $periodes = Periode::latest()->get();

        if (!$request->has('periode') && $periodes->isNotEmpty()) {
            $latestPeriodeUuid = $periodes->first()->uuid;
            return redirect()->route('survey.index', ['periode' => $latestPeriodeUuid]);
        }

        $selectedPeriode = $periodes->firstWhere('uuid', $request->periode);
        $instruments = Instrument::where('periode_id', optional($selectedPeriode)->id)->latest()->get();

        return view('pages.survey.index', compact('instruments', 'periodes'));
    }

    public function show(Instrument $instrument)
    {
        $this->authorize('viewSurvey', $instrument);

        $questions = $instrument->indicators->flatMap->questions;

        $responses = SurveyResponse::where('instrument_id', $instrument->id)
            ->where('user_id', auth()->id())
            ->whereIn('question_id', $questions->pluck('id'))
            ->get()
            ->keyBy('question_id');

        foreach ($instrument->indicators as $key1 => $indicator) {
            foreach ($indicator->questions as $key2 => $question) {
                $response = $responses->get($question->id);

                $instrument->indicators[$key1]->questions[$key2]->response = (object) [
                    'availability' => optional($response)->availability,
                    'notes' => optional($response)->notes,
                ];
            }
        }

        return view('pages.survey.show', compact('instrument'));
    }

    public function store(SubmitSurveyRequest $request, Instrument $instrument)
    {
        // $this->authorize('submitSurvey', $instrument);

        try {
            $availabilityData = $request->input('availability');
            $notesData = $request->input('notes');

            foreach ($instrument->questions as $question) {
                $questionId = $question->id;

                if (isset($availabilityData[$questionId])) {
                    $availability = $availabilityData[$questionId];
                    $notes = $notesData[$questionId] ?? '';

                    SurveyResponse::updateOrCreate(
                        [
                            'instrument_id' => $instrument->id,
                            'user_id' => auth()->user()->id,
                            'question_id' => $questionId,
                        ],
                        [
                            'availability' => $availability,
                            'notes' => $notes,
                        ]
                    );
                }
            }

            return redirect()->back()->with('success', 'Survei berhasil disimpan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan survei.']);
        }
    }
}
