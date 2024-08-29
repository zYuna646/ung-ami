<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_indicators', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('indicator');
            $table->foreignId('master_instrument_id')->constrained('master_instruments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_indicators');
    }
};
