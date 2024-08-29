<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_name',
        'is_deletable',
        'user_id'
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

    public function departments()
    {
        return $this->hasMany(Department::class);
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
}
