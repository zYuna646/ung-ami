<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instrument_entity_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('entity_id');
            $table->string('entity_type');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        
            // Define a shorter name for the unique index
            $table->unique(['instrument_id', 'entity_id', 'entity_type'], 'instrument_entity_team_unique_idx');
        });   
    }

    public function down(): void
    {
        Schema::dropIfExists('instrument_entity_team');
    }
};
