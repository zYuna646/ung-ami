<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'text',
        'indicator_id',
        'indicator',
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

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'question_unit');
    }

    public function auditResults()
    {
        return $this->hasMany(AuditResult::class);
    }
}
