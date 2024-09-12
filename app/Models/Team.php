<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'chief_auditor_id',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::uuid4();
        });
    }

    public function chief()
    {
        return $this->belongsTo(Auditor::class, 'chief_auditor_id');
    }

    public function members()
    {
        return $this->belongsToMany(Auditor::class, 'auditor_team');
    }

    public function instrumentEntities()
    {
        return $this->hasMany(InstrumentEntityTeam::class);
    }
}
