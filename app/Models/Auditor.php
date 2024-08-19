<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Auditor extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function chief_periodes()
    {
        return $this->hasMany(Periode::class, 'chief_auditor_id');
    }

    public function member_periodes()
    {
        return $this->belongsToMany(Periode::class, 'auditor_members');
    }
}
