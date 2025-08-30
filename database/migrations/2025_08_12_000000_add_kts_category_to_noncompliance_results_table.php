<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('noncompliance_results', function (Blueprint $table) {
            if (!Schema::hasColumn('noncompliance_results', 'kts_category')) {
                $table->string('kts_category')->nullable()->after('category');
            }
        });
    }

    public function down(): void
    {
        Schema::table('noncompliance_results', function (Blueprint $table) {
            if (Schema::hasColumn('noncompliance_results', 'kts_category')) {
                $table->dropColumn('kts_category');
            }
        });
    }
};


