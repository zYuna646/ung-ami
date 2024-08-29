<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'description',
        'success_factors',
    ];

    public function auditable()
    {
        return $this->morphTo();
    }
}
