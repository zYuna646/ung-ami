<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class MasterInstrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrument',
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

    public function indicators()
    {
        return $this->hasMany(MasterIndicator::class);
    }

    public function questions()
    {
        return $this->hasManyThrough(MasterQuestion::class, MasterIndicator::class);
    }
}
