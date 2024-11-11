<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_reports', function (Blueprint $table) {
            $table->text('saran');
        });
    }

    public function down(): void
    {
        Schema::table('audit_reports', function (Blueprint $table) {
            $table->dropColumn('saran');
        });
    }
};
