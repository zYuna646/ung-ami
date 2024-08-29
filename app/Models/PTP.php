<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTP extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'recommendations',
        'improvement_plan',
        'completion_schedule',
        'responsible_party'
    ];

    public function auditable()
    {
        return $this->morphTo();
    }
}
