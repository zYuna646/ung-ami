<?php

namespace App\Http\Controllers;

use App\Helpers\ModelHelper;
use App\Http\Requests\SubmitAuditResultsRequest;
use App\Http\Requests\SubmitComplianceResultsRequest;
use App\Http\Requests\SubmitSurveyRequest;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Instrument;
use App\Models\Periode;
use App\Models\Program;
use App\Models\SurveyResponse;
use App\Models\Unit;
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

    public function showAuditResults(Request $request, Instrument $instrument)
    {
        if ($request->unit == 'Fakultas' && $request->faculty) {
            $model = Faculty::where('faculty_name', $request->faculty)->first();
        } elseif ($request->unit == 'Jurusan' && $request->department) {
            $model = Department::where('department_name', $request->department)->first();
        } elseif ($request->unit == 'Program Studi' && $request->program) {
            $model = Program::where('program_name', $request->program)->first();
        } else {
            $model = Unit::where('unit_name', $request->unit)->first();
        }

        $showInstrument = isset($model->user);
        if ($showInstrument) {
            $questions = $instrument->indicators->flatMap->questions;
            foreach ($instrument->indicators as $key1 => $indicator) {
                foreach ($indicator->questions as $key2 => $question) {
                    $response = $model->auditResults->firstWhere('question_id', $question->id);

                    $instrument->indicators[$key1]->questions[$key2]->response = (object) [
                        'description' => optional($response)->description,
                        'amount_target' => optional($response)->amount_target,
                        'existence' => optional($response)->existence,
                        'compliance' => optional($response)->compliance,
                    ];
                }
            }
        }

        return view('pages.survey.audit-results', compact('instrument', 'showInstrument'));
    }

    public function storeAuditResults(SubmitAuditResultsRequest $request, Instrument $instrument)
    {
        try {
            if ($request->unit == 'Fakultas') {
                $model = Faculty::where('faculty_name', $request->faculty)->first();
            } elseif ($request->unit == 'Jurusan') {
                $model = Department::where('department_name', $request->department)->first();
            } elseif ($request->unit == 'Program Studi') {
                $model = Program::where('program_name', $request->program)->first();
            } else {
                $model = Unit::where('unit_name', $request->unit)->first();
            }

            foreach ($instrument->questions as $question) {
                $data = [
                    'description' => $request->description[$question->id],
                    'amount_target' => $request->amount_target[$question->id],
                    'existence' => $request->existence[$question->id],
                    'compliance' => $request->compliance[$question->id],
                ];

                $model->auditResults()->updateOrCreate(
                    [
                        'question_id' => $question->id,
                    ],
                    $data
                );
            }

            return redirect()->back()->with('success', 'Survei berhasil disimpan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan survei.']);
        }
    }

    public function showComplianceResults(Request $request, Instrument $instrument)
    {
        $model = ModelHelper::getModelByRequest($request);

        $showInstrument = isset($model->user);
        $questions = [];
        if ($showInstrument) {
            foreach ($instrument->questions as $key => $question) {
                $response = $model->complianceResults->firstWhere('question_id', $question->id);
                $auditResult = $model->auditResults->firstWhere('question_id', $question->id);
                if ($auditResult->compliance == 'Sesuai') {
                    $questions[$key] = $question;
                    $questions[$key]->response = (object) [
                        'description' => optional($response)->description,
                        'success_factors' => optional($response)->success_factors,
                    ];
                }
            }
        }

        return view('pages.survey.compliance-results', compact('instrument', 'showInstrument', 'questions'));
    }

    public function storeComplianceResults(SubmitComplianceResultsRequest $request, Instrument $instrument)
    {
        try {
            $model = ModelHelper::getModelByRequest($request);

            foreach ($instrument->questions as $question) {
                $auditResult = $model->auditResults->firstWhere('question_id', $question->id);
                if ($auditResult->compliance == 'Sesuai') {
                    $data = [
                        'description' => $request->description[$question->id],
                        'success_factors' => $request->success_factors[$question->id],
                    ];
    
                    $model->complianceResults()->updateOrCreate(
                        [
                            'question_id' => $question->id,
                        ],
                        $data
                    );
                }
            }

            return redirect()->back()->with('success', 'Survei berhasil disimpan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan survei.']);
        }
    }

    public function showNoncomplianceResults(Instrument $instrument)
    {
        return view('pages.survey.noncompliance-results', compact('instrument'));
    }

    public function showPTK(Instrument $instrument)
    {
        return view('pages.survey.ptk', compact('instrument'));
    }

    public function showPTP(Instrument $instrument)
    {
        return view('pages.survey.ptp', compact('instrument'));
    }
}
