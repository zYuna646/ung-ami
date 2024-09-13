<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Periode extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_name',
        'year',
        'start_date',
        'end_date',
        'standard_id',
        'tipe',
        'team_id',
        'code',
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

    public function getFormattedStartDateAttribute(): string
    {
        return Carbon::parse($this->start_date)->translatedFormat('j F Y');
    }

    public function getFormattedEndDateAttribute(): string
    {
        return Carbon::parse($this->end_date)->translatedFormat('j F Y');
    }

    public function standard()
    {
        return $this->belongsTo(Standard::class);
    }

    public function instruments()
    {
        return $this->hasMany(Instrument::class);
    }
}
