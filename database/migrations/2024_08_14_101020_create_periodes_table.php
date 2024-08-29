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
            $table->uuid('uuid')->unique();
            $table->year('year');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('standard_id')->constrained('standards')->onDelete('restrict');
            $table->string('tipe');
            $table->foreignId('chief_auditor_id')->constrained('auditors')->onDelete('restrict');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('auditor_members', function (Blueprint $table) {
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');
            $table->foreignId('auditor_id')->constrained('auditors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodes');
    }
};
