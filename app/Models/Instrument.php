<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'periode_id',
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

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class);
    }
}
