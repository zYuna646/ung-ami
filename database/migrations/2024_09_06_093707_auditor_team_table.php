<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditor_team', function (Blueprint $table) {
            $table->foreignId('auditor_id')->constrained('auditors')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditor_team');
    }
};
