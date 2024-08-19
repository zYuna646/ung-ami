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
    }

    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
};
