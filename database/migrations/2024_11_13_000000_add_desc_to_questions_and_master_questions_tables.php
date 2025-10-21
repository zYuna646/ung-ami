<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->text('desc')->nullable()->after('text');
        });

        Schema::table('master_questions', function (Blueprint $table) {
            $table->text('desc')->nullable()->after('question');
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('desc');
        });

        Schema::table('master_questions', function (Blueprint $table) {
            $table->dropColumn('desc');
        });
    }
};