<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periodes', function (Blueprint $table) {
            $table->id();
            $table->string('periode_name');
            $table->uuid('uuid')->unique();
            $table->year('year');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('standard_id')->constrained('standards')->onDelete('restrict');
            $table->foreignId('team_id')->constrained('teams')->onDelete('restrict');
            $table->string('tipe');
            $table->string('code');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodes');
    }
};
