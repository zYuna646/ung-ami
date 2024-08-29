<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_questions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code');
            $table->text('question');
            $table->foreignId('master_indicator_id')->constrained('master_indicators')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_questions');
    }
};
