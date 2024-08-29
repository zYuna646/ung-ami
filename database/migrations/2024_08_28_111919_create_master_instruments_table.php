<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_instruments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('instrument');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_instruments');
    }
};
