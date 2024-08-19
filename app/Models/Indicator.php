<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Indicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'instrument_id',
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

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
