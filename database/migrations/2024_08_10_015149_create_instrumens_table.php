<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instrumens', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->foreignId('standar_id')->constrained('standars')->onDelete('cascade');
            $table->string('tipe');
            $table->string('periode');
            $table->foreignId('ketua_id')->constrained('auditors')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('instrumen_anggota', function (Blueprint $table) {
            $table->foreignId('instrumen_id')->constrained('instrumens')->onDelete('cascade');
            $table->foreignId('auditor_id')->constrained('auditors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrumens');
    }
};
