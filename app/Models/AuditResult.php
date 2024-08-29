<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'description',
        'amount_target',
        'existence',
        'compliance',
    ];

    public function auditable()
    {
        return $this->morphTo();
    }
}
