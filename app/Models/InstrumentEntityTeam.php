<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentEntityTeam extends Model
{
    use HasFactory;

    protected $table = 'instrument_entity_team';
    protected $fillable = ['instrument_id', 'entity_id', 'entity_type', 'team_id'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
