<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AuditResultsExport implements FromView
{
    protected $instrument;
    protected $questions;

    public function __construct($instrument, $questions)
    {
        $this->instrument = $instrument;
        $this->questions = $questions;
    }

    public function view(): View
    {
        return view('exports.audit-results', ['instrument' => $this->instrument, 'questions' => $this->questions]);
    }
}
