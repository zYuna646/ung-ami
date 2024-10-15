<?php

namespace App\Http\Controllers;

use App\Constants\AuditStatus;
use App\Exports\AuditResultsExport;
use App\Helpers\ModelHelper;
use App\Http\Requests\CompleteAuditRequest;
use App\Http\Requests\SubmitAuditResultsRequest;
use App\Http\Requests\SubmitComplianceResultsRequest;
use App\Http\Requests\SubmitNoncomplianceResultsRequest;
use App\Http\Requests\SubmitPTKsRequest;
use App\Http\Requests\SubmitPTPsRequest;
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
use Maatwebsite\Excel\Facades\Excel;

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

    public function show(Request $request, Instrument $instrument)
    {
        $this->authorize('viewSurvey', $instrument);

        $questions = $instrument->indicators->flatMap->questions;

        if (auth()->user()->isAuditor()) {
            $model = ModelHelper::getModelByRequest($request);
            $userId = $model?->user_id;
        } else {
            $userId = auth()->id();
        }

        $responses = SurveyResponse::where('instrument_id', $instrument->id)
            ->where('user_id', $userId)
            ->whereIn('question_id', $questions->pluck('id'))
            ->get()
            ->keyBy('question_id');

        foreach ($instrument->indicators as $key1 => $indicator) {
            foreach ($indicator->questions as $key2 => $question) {
                $response = $responses->get($question->id);

                $instrument->indicators[$key1]->questions[$key2]->response = (object) [
                    'availability' => optional($response)->availability,
                    'notes' => optional($response)->notes,
                    'evidence' => optional($response)->evidence,
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
            $evidenceFiles = $request->file('evidence'); // Get the uploaded files

            foreach ($instrument->questions as $question) {
                $questionId = $question->id;

                if (isset($availabilityData[$questionId])) {
                    $availability = $availabilityData[$questionId];
                    $notes = $notesData[$questionId] ?? '';

                    // Handle file upload if 'Tersedia' and evidence file is provided
                    $evidenceFileName = null;
                    if ($availability === 'Tersedia' && isset($evidenceFiles[$questionId])) {
                        $file = $evidenceFiles[$questionId];
                        $evidencePath = $file->store('evidences', 'public'); // Save the file to 'public/evidences'
                        $evidenceFileName = basename($evidencePath); // Get only the basename
                    }

                    SurveyResponse::updateOrCreate(
                        [
                            'instrument_id' => $instrument->id,
                            'user_id' => auth()->user()->id,
                            'question_id' => $questionId,
                        ],
                        [
                            'availability' => $availability,
                            'notes' => $notes,
                            'evidence' => $evidenceFileName, // Store only the basename in the database
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
        $this->authorize('showAuditResults', $instrument);

        $model = ModelHelper::getModelByRequest($request);

        $showInstrument = isset($model->user);
        if ($showInstrument) {
            $questions = $instrument->indicators->flatMap->questions;
            $responses = SurveyResponse::where('instrument_id', $instrument->id)
                ->where('user_id', $model->user_id)
                ->whereIn('question_id', $questions->pluck('id'))
                ->get()
                ->keyBy('question_id');
            foreach ($instrument->indicators as $key1 => $indicator) {
                foreach ($indicator->questions as $key2 => $question) {
                    $response = $model->auditResults->firstWhere('question_id', $question->id);
                    $auditeeResponse = $responses->get($question->id);

                    $instrument->indicators[$key1]->questions[$key2]->response = (object) [
                        'availability' => optional($auditeeResponse)->availability,
                        'notes' => optional($auditeeResponse)->notes,
                        'evidence' => optional($auditeeResponse)->evidence,
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
            $this->authorize('submitAuditResults', $instrument);

            $model = ModelHelper::getModelByRequest($request);

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

    public function exportAuditResults(Request $request, Instrument $instrument)
    {
        $this->authorize('submitAuditResults', $instrument);

        $model = ModelHelper::getModelByRequest($request);

        $showInstrument = isset($model->user);
        $questions = [];
        if ($showInstrument) {
            foreach ($instrument->questions as $key => $question) {
                $response = $model->auditResults->firstWhere('question_id', $question->id);
                $questions[$key] = $question;
                $questions[$key]->response = (object) [
                    'description' => optional($response)->description,
                    'amount_target' => optional($response)->amount_target,
                    'existence' => optional($response)->existence,
                    'compliance' => optional($response)->compliance,
                ];
            }
        }

        return Excel::download(new AuditResultsExport($instrument, $questions), 'Hasil Audit Lapangan.xlsx');
    }

    public function showComplianceResults(Request $request, Instrument $instrument)
    {
        $this->authorize('showComplianceResults', $instrument);

        $model = ModelHelper::getModelByRequest($request);

        $showInstrument = isset($model->user);
        $questions = [];
        if ($showInstrument) {
            foreach ($instrument->questions as $key => $question) {
                $response = $model->complianceResults->firstWhere('question_id', $question->id);
                $auditResult = $model->auditResults->firstWhere('question_id', $question->id);
                if ($auditResult?->compliance == 'Sesuai') {
                    $questions[$key] = $question;
                    $questions[$key]->response = (object) [
                        'description' => optional($response)->description,
                        'success_factors' => optional($response)->success_factors,
                    ];
                }
            }
        }
        $showInstrument = count($questions) > 0;

        return view('pages.survey.compliance-results', compact('instrument', 'showInstrument', 'questions'));
    }

    public function storeComplianceResults(SubmitComplianceResultsRequest $request, Instrument $instrument)
    {
        try {
            $this->authorize('submitComplianceResults', $instrument);

            $model = ModelHelper::getModelByRequest($request);

            foreach ($instrument->questions as $question) {
                $auditResult = $model->auditResults->firstWhere('question_id', $question->id);
                if ($auditResult?->compliance == 'Sesuai') {
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

    public function showNoncomplianceResults(Request $request, Instrument $instrument)
    {
        $this->authorize('showNoncomplianceResults', $instrument);

        $model = ModelHelper::getModelByRequest($request);

        $showInstrument = isset($model->user);
        $questions = [];
        if ($showInstrument) {
            foreach ($instrument->questions as $key => $question) {
                $response = $model->noncomplianceResults->firstWhere('question_id', $question->id);
                $auditResult = $model->auditResults->firstWhere('question_id', $question->id);
                if ($auditResult?->compliance == 'Tidak Sesuai') {
                    $questions[$key] = $question;
                    $questions[$key]->response = (object) [
                        'description' => optional($response)->description,
                        'category' => optional($response)->category,
                        'barriers' => optional($response)->barriers,
                    ];
                }
            }
        }
        $showInstrument = count($questions) > 0;

        return view('pages.survey.noncompliance-results', compact('instrument', 'showInstrument', 'questions'));
    }

    public function storeNoncomplianceResults(SubmitNoncomplianceResultsRequest $request, Instrument $instrument)
    {
        try {
            $this->authorize('submitNoncomplianceResults', $instrument);

            $model = ModelHelper::getModelByRequest($request);

            foreach ($instrument->questions as $question) {
                $auditResult = $model->auditResults->firstWhere('question_id', $question->id);
                if ($auditResult?->compliance == 'Tidak Sesuai') {
                    $data = [
                        'description' => $request->description[$question->id],
                        'category' => $request->category[$question->id],
                        'barriers' => $request->barriers[$question->id],
                    ];

                    $model->noncomplianceResults()->updateOrCreate(
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

    public function showPTK(Request $request, Instrument $instrument)
    {
        $this->authorize('showPTK', $instrument);

        $model = ModelHelper::getModelByRequest($request);

        $showInstrument = isset($model->user);
        $questions = [];
        if ($showInstrument) {
            foreach ($instrument->questions as $key => $question) {
                $response = $model->PTKs->firstWhere('question_id', $question->id);
                $auditResult = $model->auditResults->firstWhere('question_id', $question->id);
                $noncomplianceResult = $model->noncomplianceResults->firstWhere('question_id', $question->id);
                if ($auditResult?->compliance == 'Tidak Sesuai' && $noncomplianceResult?->category == 'KTS') {
                    $questions[$key] = $question;
                    $questions[$key]->response = (object) [
                        'description' => optional($auditResult)->description,
                        'barriers' => optional($noncomplianceResult)->barriers,
                        'recommendations' => optional($response)->recommendations,
                        'improvement_plan' => optional($response)->improvement_plan,
                        'completion_schedule' => optional($response)->completion_schedule,
                        'monitoring_mechanism' => optional($response)->monitoring_mechanism,
                        'responsible_party' => optional($response)->responsible_party,
                    ];
                }
            }
        }
        $showInstrument = count($questions) > 0;

        return view('pages.survey.ptk', compact('instrument', 'showInstrument', 'questions'));
    }

    public function storePTK(SubmitPTKsRequest $request, Instrument $instrument)
    {
        try {
            $this->authorize('submitPTK', $instrument);

            $model = ModelHelper::getModelByRequest($request);

            foreach ($instrument->questions as $question) {
                $auditResult = $model->auditResults->firstWhere('question_id', $question->id);
                $noncomplianceResult = $model->noncomplianceResults->firstWhere('question_id', $question->id);
                if ($auditResult?->compliance == 'Tidak Sesuai' && $noncomplianceResult?->category == 'KTS') {
                    $data = [
                        'recommendations' => $request->recommendations[$question->id],
                        'improvement_plan' => $request->improvement_plan[$question->id],
                        'completion_schedule' => $request->completion_schedule[$question->id],
                        'monitoring_mechanism' => $request->monitoring_mechanism[$question->id],
                        'responsible_party' => $request->responsible_party[$question->id],
                    ];

                    $model->PTKs()->updateOrCreate(
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

    public function showPTP(Request $request, Instrument $instrument)
    {
        $this->authorize('showPTP', $instrument);

        $model = ModelHelper::getModelByRequest($request);

        $showInstrument = isset($model->user);
        $questions = [];
        if ($showInstrument) {
            foreach ($instrument->questions as $key => $question) {
                $response = $model->PTPs->firstWhere('question_id', $question->id);
                $auditResult = $model->auditResults->firstWhere('question_id', $question->id);
                $complianceResult = $model->complianceResults->firstWhere('question_id', $question->id);
                if ($auditResult?->compliance == 'Sesuai') {
                    $questions[$key] = $question;
                    $questions[$key]->response = (object) [
                        'description' => optional($auditResult)->description,
                        'success_factors' => optional($complianceResult)->success_factors,
                        'recommendations' => optional($response)->recommendations,
                        'improvement_plan' => optional($response)->improvement_plan,
                        'completion_schedule' => optional($response)->completion_schedule,
                        'responsible_party' => optional($response)->responsible_party,
                    ];
                }
            }
        }
        $showInstrument = count($questions) > 0;

        return view('pages.survey.ptp', compact('instrument', 'showInstrument', 'questions'));
    }

    public function storePTP(SubmitPTPsRequest $request, Instrument $instrument)
    {
        try {
            $this->authorize('submitPTP', $instrument);

            $model = ModelHelper::getModelByRequest($request);

            foreach ($instrument->questions as $question) {
                $auditResult = $model->auditResults->firstWhere('question_id', $question->id);
                if ($auditResult?->compliance == 'Sesuai') {
                    $data = [
                        'recommendations' => $request->recommendations[$question->id],
                        'improvement_plan' => $request->improvement_plan[$question->id],
                        'completion_schedule' => $request->completion_schedule[$question->id],
                        'responsible_party' => $request->responsible_party[$question->id],
                    ];

                    $model->PTPs()->updateOrCreate(
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

    public function processAudit(Request $request, Instrument $instrument)
    {
        try {
            $this->authorize('processAudit', $instrument);
            $model = ModelHelper::getModelByRequest($request);
            $data = [
                'status' => AuditStatus::PROCESS,
                'auditor_id' => auth()->user()->auditor->id,
            ];
            $model->auditStatus()->updateOrCreate(
                ['instrument_id' => $instrument->id],
                $data
            );

            return redirect()->back()->with('success', 'Survei berhasil diteruskan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan survei.']);
        }
    }

    public function rejectAudit(Request $request, Instrument $instrument)
    {
        try {
            $this->authorize('rejectAudit', $instrument);
            $model = ModelHelper::getModelByArea($request->area);
            $data = [
                'status' => AuditStatus::REJECTED,
            ];
            $model->auditStatus()->updateOrCreate(
                ['instrument_id' => $instrument->id],
                $data
            );

            return redirect()->back()->with('success', 'Survei telah ditolak.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan survei.']);
        }
    }

    public function completeAudit(CompleteAuditRequest $request, Instrument $instrument)
    {
        try {
            $this->authorize('completeAudit', $instrument);
            $model = ModelHelper::getModelByArea($request->area);
            $data = [
                'status' => AuditStatus::COMPLETE,
                // 'meeting_report' => basename($request->file('meeting_report')->store('public/audits')),
                // 'activity_evidence' => basename($request->file('activity_evidence')->store('public/audits')),
            ];
            $model->auditStatus()->updateOrCreate(
                ['instrument_id' => $instrument->id],
                $data
            );

            return redirect()->back()->with('success', 'Survei berhasil dikonfirmasi.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan survei.']);
        }
    }

    public function showReport(Request $request, Instrument $instrument)
    {
        $this->authorize('showReport', $instrument);

        $model = ModelHelper::getModelByArea($request->area ?? auth()->user()->entityId() . auth()->user()->entityType());
        $auditStatus = $model->auditStatus()->where('instrument_id', $instrument->id)->first();

        return view('pages.survey.report', compact('instrument', 'auditStatus'));
    }

    public function previewReport(Request $request, Instrument $instrument)
    {
        $this->authorize('showReport', $instrument);

        //
    }
}
