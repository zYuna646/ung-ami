<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->constrained()->onDelete('cascade');
            $table->foreignId('auditor_id')->constrained()->onDelete('cascade');
            $table->string('status')->nullable();
            $table->string('meeting_report')->nullable();
            $table->string('activity_evidence')->nullable();
            $table->morphs('auditable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_statuses');
    }
};
