<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'is_deletable',
        'user_id',
        'department_id'
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();
        self::saving(function ($model) {
            if (!$model->exists) $model->uuid = (string) Uuid::uuid4();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function auditResults()
    {
        return $this->morphMany(AuditResult::class, 'auditable');
    }

    public function complianceResults()
    {
        return $this->morphMany(ComplianceResult::class, 'auditable');
    }

    public function noncomplianceResults()
    {
        return $this->morphMany(NoncomplianceResult::class, 'auditable');
    }

    public function PTKs()
    {
        return $this->morphMany(PTK::class, 'auditable');
    }

    public function PTPs()
    {
        return $this->morphMany(PTP::class, 'auditable');
    }

    public function auditStatus()
    {
        return $this->morphMany(AuditStatus::class, 'auditable');
    }

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'instrument_program');
    }

    public function periodes()
    {
        return $this->hasManyThrough(
            Periode::class,
            Instrument::class,
            'id',
            'id',
            'id',
            'periode_id'
        );
    }

    public function auditReports()
    {
        return $this->belongsToMany(Periode::class, 'audit_reports')->withPivot('meeting_report', 'activity_evidences');
    }
}
