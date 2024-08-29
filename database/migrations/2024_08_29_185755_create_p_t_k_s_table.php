<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('p_t_k_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->string('recommendations');
            $table->string('improvement_plan');
            $table->string('completion_schedule');
            $table->string('monitoring_mechanism');
            $table->string('responsible_party');
            $table->morphs('auditable');
            $table->timestamps();
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('p_t_k_s');
    }
};
