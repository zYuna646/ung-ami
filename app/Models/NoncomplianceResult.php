<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoncomplianceResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'description',
        'category',
        'barriers',
    ];

    public function auditable()
    {
        return $this->morphTo();
    }
}
