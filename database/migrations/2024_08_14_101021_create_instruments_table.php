<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');            
            $table->timestamps();
        });
        Schema::create('instrument_unit', function (Blueprint $table) {
            $table->foreignId('instrument_id')->constrained('instruments')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instruments');
        Schema::dropIfExists('instrument_unit');
    }
};
