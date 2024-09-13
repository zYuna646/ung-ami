<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrument_id',
        'auditor_id',
        'auditable_type',
        'auditable_id',
        'status',
        'meeting_report',
        'activity_evidence'
    ];

    protected $appends = ['meeting_report_url', 'activity_evidence_url'];

    public function auditable()
    {
        return $this->morphTo();
    }

    public function getMeetingReportUrlAttribute(): string
    {
        return asset('/storage/audits/' . $this->meeting_report);
    }

    public function getActivityEvidenceUrlAttribute(): string
    {
        return asset('/storage/audits/' . $this->activity_evidence);
    }
}
