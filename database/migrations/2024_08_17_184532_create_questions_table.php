<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code');
            $table->text('text');
            $table->foreignId('indicator_id')->constrained('indicators')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('question_unit', function (Blueprint $table) {
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_unit');
    }
};
