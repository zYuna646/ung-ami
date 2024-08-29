<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('amount_target');
            $table->string('existence');
            $table->string('compliance');
            $table->morphs('auditable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_results');
    }
};
