<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTK extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'recommendations',
        'improvement_plan',
        'completion_schedule',
        'monitoring_mechanism',
        'responsible_party'
    ];

    public function auditable()
    {
        return $this->morphTo();
    }
}
