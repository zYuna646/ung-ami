<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadAuditReport;
use App\Models\Periode;
use App\Models\Program;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAnyReport', Program::class);

        $programs = Program::latest()->get();
        $periodes = Periode::latest()->get();
        $program = (object) [];
        $programPeriodes = [];

        if (!$request->has('program') && auth()->user()->isProgram()) {
            return redirect()->route('report.index', ['program' => auth()->user()->program->uuid]);
        }

        if ($request->has('program')) {
            $program = Program::where('uuid', $request->program)->first();
            $programPeriodes = Periode::whereHas('instruments', function ($query) use ($program) {
                $query->whereIn('id', $program->instruments->pluck('id'));
            })->get();
        }

        return view('pages.report.index', compact('periodes', 'programs', 'program', 'programPeriodes'));
    }

    public function upload(UploadAuditReport $request, Periode $periode, Program $program)
    {
        try {
            $fileNames = [];

            if ($request->hasFile('activity_evidences')) {
                foreach ($request->file('activity_evidences') as $file) {
                    $name = basename($file->store('public/audits'));
                    $fileNames[] = $name;
                }
            }

            $program->auditReports()->attach($periode->id, [
                'meeting_report' => basename($request->file('meeting_report')->store('public/audits')),
                'activity_evidences' => json_encode($fileNames), // Save as JSON
            ]);

            return redirect()->back()->with('success', 'File berhasil diunggah.');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan.']);
        }
    }

    public function bab1(Periode $periode, Program $program)
    {
        $instruments = $program->instruments()->where('periode_id', $periode->id)->get();
        $pdf = Pdf::loadView('pdf.bab-1', compact('periode', 'program', 'instruments'))->setPaper('a4', 'portrait');

        return $pdf->stream('BAB I - Laporan AMI ' . $program->program_name  . ' Tahun ' . $periode->year . '.pdf');
    }

    public function bab2(Periode $periode, Program $program)
    {
        $instruments = $program->instruments()->where('periode_id', $periode->id)->get();
        $pdf = Pdf::loadView('pdf.bab-2', compact('periode', 'program', 'instruments'))->setPaper('a4', 'portrait');

        return $pdf->stream('BAB II - Laporan AMI ' . $program->program_name  . ' Tahun ' . $periode->year . '.pdf');
    }

    public function bab3(Periode $periode, Program $program)
    {
        $instruments = $program->instruments()->where('periode_id', $periode->id)->get();

        $part1 = Pdf::loadView('pdf.bab-3-part-1', compact('periode', 'program', 'instruments'))
            ->setPaper('a4', 'landscape')
            ->output();

        $kriteria = [];
        $totalKesesuaian = 0;
        $totalQuestions = 0;

        foreach ($instruments as $instrument) {
            $kriteria[] = [
                'name' => $instrument->name,
                'count' => [
                    'kesesuaian' => 0,
                    'ketidaksesuaian' => 0,
                    'obs' => 0,
                    'kts' => 0,
                    'totalAuditResult' => 0,
                ]
            ];

            // Reference the last item in the $kriteria array to update counts
            $currentIndex = count($kriteria) - 1;

            foreach ($instrument->questions as $question) {
                $auditResult = $program->auditResults->firstWhere('question_id', $question->id);
                $noncomplianceResult = $program->noncomplianceResults->firstWhere('question_id', $question->id);

                if ($auditResult?->compliance == 'Sesuai') {
                    $kriteria[$currentIndex]['count']['kesesuaian']++;
                    $kriteria[$currentIndex]['count']['totalAuditResult']++;
                }

                if ($auditResult?->compliance == 'Tidak Sesuai') {
                    $kriteria[$currentIndex]['count']['ketidaksesuaian']++;
                    $kriteria[$currentIndex]['count']['totalAuditResult']++;
                }

                if ($noncomplianceResult?->category == 'OBS') {
                    $kriteria[$currentIndex]['count']['obs']++;
                }

                if ($noncomplianceResult?->category == 'KTS') {
                    $kriteria[$currentIndex]['count']['kts']++;
                }
            }

            // Calculate the total questions for compliance rate calculation
            $totalQuestions += $kriteria[$currentIndex]['count']['kesesuaian'] + $kriteria[$currentIndex]['count']['ketidaksesuaian'];
            $totalKesesuaian += $kriteria[$currentIndex]['count']['kesesuaian'];

            // Calculate compliance percentage for each instrument
            $totalInstrumentQuestions = $kriteria[$currentIndex]['count']['kesesuaian'] + $kriteria[$currentIndex]['count']['ketidaksesuaian'];
            $kriteria[$currentIndex]['compliance_percentage'] = $totalInstrumentQuestions > 0
                ? number_format(($kriteria[$currentIndex]['count']['kesesuaian'] / $totalInstrumentQuestions) * 100, 1)
                : 0;
        }

        // Determine the criterion with the lowest compliance percentage
        $lowestCompliance = collect($kriteria)->sortBy('compliance_percentage')->first();

        // Calculate the average compliance percentage
        $averageCompliance = $totalQuestions > 0
            ? number_format(($totalKesesuaian / $totalQuestions) * 100, 1)
            : 0;

        $part2 = Pdf::loadView('pdf.bab-3-part-2', compact('periode', 'program', 'instruments', 'kriteria', 'lowestCompliance', 'averageCompliance'))
            ->setPaper('a4', 'portrait')
            ->output();

        $pdf = PdfMerger::init();

        $pdf->addString($part1);
        $pdf->addString($part2);
        $pdf->merge();
        $pdf->setFileName('BAB III - Laporan AMI ' . $program->program_name  . ' Tahun ' . $periode->year . '.pdf');

        return $pdf->stream();
    }

    public function bab4(Periode $periode, Program $program)
    {
        $instruments = $program->instruments()->where('periode_id', $periode->id)->get();
        $pdf = Pdf::loadView('pdf.bab-4', compact('periode', 'program', 'instruments'))->setPaper('a4', 'landscape');

        return $pdf->stream('BAB IV - Laporan AMI ' . $program->program_name  . ' Tahun ' . $periode->year . '.pdf');
    }

    public function bab5(Periode $periode, Program $program)
    {
        $instruments = $program->instruments()->where('periode_id', $periode->id)->get();
        $pdf = Pdf::loadView('pdf.bab-5', compact('periode', 'program', 'instruments'))->setPaper('a4', 'portrait');

        return $pdf->stream('BAB V - Laporan AMI ' . $program->program_name  . ' Tahun ' . $periode->year . '.pdf');
    }

    public function lampiran(Periode $periode, Program $program)
    {
        $instruments = $program->instruments()->where('periode_id', $periode->id)->get();
        $pdf = Pdf::loadView('pdf.lampiran', compact('periode', 'program', 'instruments'))->setPaper('a4', 'portrait');

        return $pdf->stream('Lampiran - Laporan AMI ' . $program->program_name  . ' Tahun ' . $periode->year . '.pdf');
    }

    public function full(Periode $periode, Program $program)
    {
        $instruments = $program->instruments()->where('periode_id', $periode->id)->get();

        $pdfMerger = PDFMerger::init();

        $bab1 = Pdf::loadView('pdf.bab-1', compact('periode', 'program'))
            ->setPaper('a4', 'portrait')
            ->output();
        $pdfMerger->addString($bab1);

        $bab2 = Pdf::loadView('pdf.bab-2', compact('periode', 'program'))
            ->setPaper('a4', 'portrait')
            ->output();
        $pdfMerger->addString($bab2);

        $bab3Part1 = Pdf::loadView('pdf.bab-3-part-1', compact('periode', 'program', 'instruments'))
            ->setPaper('a4', 'landscape')
            ->output();
        $bab3Part2 = Pdf::loadView('pdf.bab-3-part-2', compact('periode', 'program'))
            ->setPaper('a4', 'portrait')
            ->output();
        $pdfMerger->addString($bab3Part1);
        $pdfMerger->addString($bab3Part2);

        $bab4 = Pdf::loadView('pdf.bab-4', compact('periode', 'program', 'instruments'))
            ->setPaper('a4', 'landscape')
            ->output();
        $pdfMerger->addString($bab4);

        $bab5 = Pdf::loadView('pdf.bab-5', compact('periode', 'program'))
            ->setPaper('a4', 'portrait')
            ->output();
        $pdfMerger->addString($bab5);

        $lampiran = Pdf::loadView('pdf.lampiran', compact('periode', 'program'))
            ->setPaper('a4', 'portrait')
            ->output();
        $pdfMerger->addString($lampiran);

        $pdfMerger->merge();
        $pdfMerger->setFileName('Laporan AMI ' . $program->program_name  . ' Tahun ' . $periode->year . '.pdf');
        return $pdfMerger->download();
    }
}
