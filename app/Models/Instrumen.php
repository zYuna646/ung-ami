<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Instrumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'standar_id',
        'tipe',
        'periode',
        'ketua_id',
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

    public function standar()
    {
        return $this->belongsTo(Standar::class);
    }

    public function ketua()
    {
        return $this->belongsTo(Auditor::class, 'ketua_id');
    }

    public function anggota()
    {
        return $this->belongsToMany(Auditor::class, 'instrumen_anggota');
    }

    public function indikator()
    {
        return $this->hasMany(Indikator::class);
    }
}
