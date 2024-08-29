<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class MasterQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'code',
        'master_indicator_id'
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
}
