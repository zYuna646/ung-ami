<?php

namespace App\Http\Controllers;

use App\Exports\ExportRTM;
use App\Exports\RangkingExport;
use App\Http\Requests\StorePeriodeRequest;
use App\Http\Requests\UpdatePeriodeRequest;
use App\Models\Auditor;
use App\Models\AuditResult;
use App\Models\ComplianceResult;
use App\Models\Department;
use App\Models\MasterInstrument;
use App\Models\NoncomplianceResult;
use App\Models\Periode;
use App\Models\Program;
use App\Models\PTK;
use App\Models\PTP;
use App\Models\Standard;
use App\Models\Team;
use App\Models\Unit;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;
use Maatwebsite\Excel\Facades\Excel;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::get();

        return view('pages.dashboard.master.periodes.index', compact('periodes'));
    }

    public function create()
    {
        $standards = Standard::get();
        $teams = Team::get();

        return view('pages.dashboard.master.periodes.create', compact('standards', 'teams'));
    }

    public function store(StorePeriodeRequest $request)
    {
        try {
            $data = $request->validated();
            $periode = Periode::create($data);

            return redirect()->route('dashboard.master.periodes.show', $periode->uuid)->with('success', 'Data berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function show(Periode $periode)
    {
        $auditors = Auditor::all();
        $units = Unit::get();
        $masterInstruments = MasterInstrument::get();

        $total = 0;
        $question_id = [];
        $rtm = [];
        foreach ($periode->instruments as $instrument) {
            foreach ($instrument->indicators as $indicator) {
                foreach ($indicator->questions as $question) {
                    $total++;
                    $question_id[] = $question->id;
                }
            }
        }
        $fakultas = Department::all();
        $total_rtm = Program::all()->count();
        $prodi = Program::all();
        // dd(Program::all()->co)

        $data = Program::all()->map(function ($program) use ($question_id, $total) {
            $compilance = ComplianceResult::whereIn('question_id', $question_id)->where('auditable_id', $program->id)->get();
            $noncompilance = NoncomplianceResult::whereIn('question_id', $question_id)->where('auditable_id', $program->id)->get();
            $ptps = PTP::whereIn('question_id', $question_id)->where('auditable_id', $program->id)->get();
            $ptks = PTK::whereIn('question_id', $question_id)->where('auditable_id', $program->id)->get();
            $sesuai = AuditResult::where('auditable_id', $program->id)->whereIn('question_id', $question_id)->where('compliance', 'Sesuai')->count();
            $tidak_sesuai = AuditResult::where('auditable_id', $program->id)->whereIn('question_id', $question_id)->where('compliance', 'Tidak Sesuai')->count();
            return [
                'program' => $program,
                'ptp' => $ptps->count(),
                'ptk' => $ptks->count(),
                'sesuai' => $sesuai,
                'tidak_sesuai' => $tidak_sesuai,
                'compilance' => $compilance->count(),
                'noncompilance' => $noncompilance->count(),
                'kts' => $noncompilance->where('category', 'KTS')->count(),
                'obs' => $noncompilance->where('category', 'OBS')->count(),
                'score' => $total > 0 ? number_format(($sesuai / $total) * 100, 2) : 0,
            ];
        })->sortByDesc('score')->values();
        // Proses pertanyaan dan hitung nilai
        foreach ($periode->instruments as $instrument) {
            foreach ($instrument->indicators as $indicator) {
                foreach ($indicator->questions as $question) {
                    $obs = NoncomplianceResult::where('question_id', $question->id)->where('category', 'OBS')->count();
                    $kts = NoncomplianceResult::where('question_id', $question->id)->where('category', 'KTS')->count();
                    $ptp = PTP::where('question_id', $question->id)->count();

                    $instrumentKey = $question->indicator->instrument->name;
                    $selisih = $total_rtm - ($obs + $kts + $ptp);
                    $obs = $kts + $selisih < 0 ? $obs - abs($kts + $selisih) : $obs;
                    $rtm[$instrumentKey][] = [
                        'code' => $question->code,
                        'desc' => $question->text,
                        'ptp' => $ptp,
                        'kts' => $kts + $selisih > 0 ? $kts + $selisih : 0,
                        'obs' => $obs,
                        'score' => $total_rtm > 0 ? number_format(($ptp / $total) * 100, 2) : 0
                    ];

                    $question_id[] = $question->id;
                }
            }
        }
        $programs = Program::with(['PTPs', 'noncomplianceResults', 'PTKs', 'complianceResults'])->get()->map(function ($program) use ($total, $question_id) {
            // dd($program->PTPs[0]);
            return [
                'program' => $program,
                'ptp' => $program->PTPs()->whereIn('question_id', $question_id)->get(),
                'ptk' => $program->PTKs()->whereIn('question_id', $question_id)->get(),
                'sesuai' => $program->complianceResults()->whereIn('question_id', $question_id)->get(),
                'kts' => $program->noncomplianceResults()->where('category', 'KTS')->whereIn('question_id', $question_id)->get(),
                'obs' => $program->noncomplianceResults()->where('category', 'OBS')->whereIn('question_id', $question_id)->get(),
                'score' => $total > 0 ? number_format(($program->PTPs->count() / $total) * 100, 2) : 0,
                'total_answer' => $program->PTPs->count() + $program->PTKs->count() + $program->noncomplianceResults()->where('category', 'OBS')->whereIn('question_id', $question_id)->count(),
                'total' => $total,
            ];
        })->sortByDesc('score')->values();
        return view('pages.dashboard.master.periodes.show', compact('periode', 'units', 'masterInstruments', 'programs', 'rtm', 'fakultas', 'prodi', 'total', 'data'));
    }


    public function exportRtm(Request $request, Periode $periode)
    {
        // Ambil data pendukung (bisa disesuaikan jika diperlukan)
        $auditors = Auditor::all();
        $units = Unit::get();
        $masterInstruments = MasterInstrument::get();

        // Siapkan filter auditable_id berdasarkan prodi atau fakultas jika ada
        $auditable_id = [];
        $total_rtm = Program::all()->count();

        if ($request->prodi) {
            $auditable_id[] = $request->prodi;
        } elseif ($request->fakultas) {
            // Perbaiki "pluc" menjadi "pluck" dan konversi ke array
            // dd( Department::find($request->fakultas)->programs);
            $auditable_id = Department::find($request->fakultas)->programs->pluck('id')->toArray();
            $total_rtm = Department::find($request->fakultas)->programs()->count();
        }

        // Hitung total pertanyaan
        $total = 0;
        $question_id = [];
        $rtm = [];
        foreach ($periode->instruments as $instrument) {
            foreach ($instrument->indicators as $indicator) {
                foreach ($indicator->questions as $question) {
                    $total++;
                }
            }
        }


        // Proses pertanyaan dan hitung nilai
        foreach ($periode->instruments as $instrument) {
            foreach ($instrument->indicators as $indicator) {
                foreach ($indicator->questions as $question) {
                    // dd($question);
                    // Query untuk OBS
                    $sesuai = AuditResult::where('question_id', $question->id)->whereIn('auditable_id', $auditable_id)->where('compliance', 'Sesuai')->count();
                    $tidak_sesuai = AuditResult::where('question_id', $question->id)->whereIn('auditable_id', $auditable_id)->where('compliance', 'Tidak Sesuai')->count();
                    // dd($sesuai, $tidak_sesuai);
                    $ptps = PTP::where('question_id', $question->id)->whereIn('auditable_id', $auditable_id)->count();
                    $ptks = PTK::where('question_id', $question->id)->whereIn('auditable_id', $auditable_id)->count();
                    $compilance = ComplianceResult::where('question_id', $question->id)->whereIn('auditable_id', $auditable_id)->count();
                    $noncompilance = NoncomplianceResult::where('question_id', $question->id)->whereIn('auditable_id', $auditable_id)->count();
                    // $kts = NoncomplianceResult::where('question_id', $question->id)->whereIn('auditable_id', $auditable_id)->where('category', 'KTS')->count();
                    // $obs = NoncomplianceResult::where('question_id', $question->id)->whereIn('auditable_id', $auditable_id)->where('category', 'OBS')->count();
                    // $total_sum = $ptps + $ptks + $obs;
                    // $selisih = abs($total_sum - $total);
                    // $obs = $obs - $selisih;
                    // if ($obs < 0) {
                    //     $ptks = $ptks + $obs;
                    //     $ptks = $ptks < 0 ? 0 : $ptks;
                    //     $obs = 0;
                    // }

                    // if ($obs + $ptks < $tidak_sesuai) {
                    //     $ptks = ($tidak_sesuai - ($obs + $ptks));
                    // }

                    // $total_sum = $ptps + $ptks + $obs;
                    $score = $total > 0 ? number_format(($sesuai / count($auditable_id)) * 100, 2) : 0;

                    $instrumentKey = $question->indicator->instrument->name;
                    
                    
                    $rtm[$instrumentKey][] = [
                        'id' => $question->id,
                        'code' => $question->code,
                        'desc' => $question->text,
                        'ptp' => $sesuai,
                        'kts' => $tidak_sesuai,
                        // 'obs' => 0,
                        'score' => $score
                    ];

                    $question_id[] = $question->id;
                }
            }
        }

        $fakultas = $request->fakultas ? Department::find($request->fakultas)->department_name : 'Semua Fakultas';

        // Download file Excel dengan menggunakan ExportRTM dan data $rtm
        return Excel::download(new ExportRTM($rtm), 'rtm_report_' . $fakultas . '.xlsx');
    }

    public function exportRangking(Periode $periode)
    {
        $auditors = Auditor::all();
        $units = Unit::get();
        $masterInstruments = MasterInstrument::get();

        $total = 0;
        // foreach ($masterInstruments as $key => $instrument) {
        //     $total += $instrument->questions()->count();
        // }
        $question_id = [];
        foreach ($periode->instruments as $instrument) {
            foreach ($instrument->indicators as $indicator) {
                foreach ($indicator->questions as $question) {
                    $question_id[] = $question->id;
                    $total += 1;
                }
            }
        }

        $data = Program::all()->map(function ($program) use ($question_id, $total) {
            $compilance = ComplianceResult::whereIn('question_id', $question_id)->where('auditable_id', $program->id)->get();
            $noncompilance = NoncomplianceResult::whereIn('question_id', $question_id)->where('auditable_id', $program->id)->get();
            $ptps = PTP::whereIn('question_id', $question_id)->where('auditable_id', $program->id)->get();
            $ptks = PTK::whereIn('question_id', $question_id)->where('auditable_id', $program->id)->get();
            $sesuai = AuditResult::where('auditable_id', $program->id)->whereIn('question_id', $question_id)->where('compliance', 'Sesuai')->count();
            $tidak_sesuai = AuditResult::where('auditable_id', $program->id)->whereIn('question_id', $question_id)->where('compliance', 'Tidak Sesuai')->count();

            // $PTPs = $ptps->count();
            // $PTKs = $ptks->count();
            // $OBS = $noncompilance->where('category', 'OBS')->count();
            // $KTS = $noncompilance->where('category', 'KTS')->count();
            // $TIDAK_SESUAI = $tidak_sesuai;
            // $SESUAI = $sesuai;

            // $total_sum = $PTPs + $PTKs + $OBS;
            // $selisih = abs($total_sum - $total);
            // $OBS = $OBS - $selisih;
            // if ($OBS < 0) {
            //     $PTKs = $PTKs + $OBS;
            //     $PTKs = $PTKs < 0 ? 0 : $PTKs;
            //     $OBS = 0;
            // }

            // if ($OBS + $PTKs < $TIDAK_SESUAI) {
            //     $PTKs = ($TIDAK_SESUAI - ($OBS + $PTKs));
            // }

            // $total_sum = $PTPs + $PTKs + $OBS;
            $total_sum = $sesuai + $tidak_sesuai;
            $score = $total > 0 ? number_format(($sesuai / $total) * 100, 2) : 0;

            return [
                'program' => $program,
                'Tidak Sesuai' => $tidak_sesuai,
                'Sesuai' => $sesuai,
                'total' => $total_sum,
                'score' => $score,
            ];
        })->sortByDesc('score')->values();


        return Excel::download(new RangkingExport($data), 'ranking.xlsx');
    }



    public function edit(Periode $periode)
    {
        $standards = Standard::get();
        $auditors = Auditor::all();
        $teams = Team::get();


        return view('pages.dashboard.master.periodes.edit', compact('periode', 'standards', 'teams'));
    }

    public function update(UpdatePeriodeRequest $request, Periode $periode)
    {
        try {
            $data = $request->validated();
            $periode->update($data);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function destroy(Periode $periode)
    {
        try {
            $periode->delete();

            return redirect()->route('dashboard.master.periodes.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan.'])->withInput();
        }
    }

    public function addMember(Request $request, Periode $periode)
    {
        try {
            $request->validate([
                'auditor_id' => 'required|exists:auditors,id',
            ]);

            $auditor = Auditor::findOrFail($request->auditor_id);

            if ($periode->auditor_members->contains($auditor)) {
                return redirect()->back()->withErrors(['error' => 'Auditor telah menjadi anggota.']);
            }

            if ($auditor->id == $periode->chief_auditor_id) {
                return redirect()->back()->withErrors(['error' => 'Auditor telah menjadi ketua.']);
            }

            $periode->auditor_members()->attach($auditor->id);

            return redirect()->back()->with('success', 'Anggota berhasil ditambahkan.');
        } catch (\Throwable $th) {
            logger()->error('Error adding member: ' . $th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan anggota.'])->withInput();
        }
    }

    public function deleteMember(Periode $periode, Auditor $auditor)
    {
        try {
            $isMember = $periode->auditor_members->contains($auditor);

            if (!$isMember) {
                return redirect()->back()->withErrors(['error' => 'Auditor bukan anggota.']);
            }

            $periode->auditor_members()->detach($auditor);

            return redirect()->back()->with('success', 'Anggota berhasil dihapus.');
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus anggota.'])->withInput();
        }
    }
}
