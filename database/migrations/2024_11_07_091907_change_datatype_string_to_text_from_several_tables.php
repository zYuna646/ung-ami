<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_results', function (Blueprint $table) {
            $table->text('description')->change();
        });
        Schema::table('p_t_k_s', function (Blueprint $table) {
            $table->text('recommendations')->change();
            $table->text('improvement_plan')->change();
            $table->text('completion_schedule')->change();
            $table->text('monitoring_mechanism')->change();
            $table->text('responsible_party')->change();
        });
        Schema::table('p_t_p_s', function (Blueprint $table) {
            $table->text('recommendations')->change();
            $table->text('improvement_plan')->change();
            $table->text('completion_schedule')->change();
            $table->text('responsible_party')->change();
        });
    }

    public function down(): void
    {
        Schema::table('audit_results', function (Blueprint $table) {
            $table->string('description')->change(); // Revert to the original type
        });
        Schema::table('p_t_k_s', function (Blueprint $table) {
            $table->string('recommendations')->change(); // Revert to the original type
            $table->string('improvement_plan')->change();
            $table->string('completion_schedule')->change();
            $table->string('monitoring_mechanism')->change();
            $table->string('responsible_party')->change();
        });
        Schema::table('p_t_p_s', function (Blueprint $table) {
            $table->string('recommendations')->change(); // Revert to the original type
            $table->string('improvement_plan')->change();
            $table->string('completion_schedule')->change();
            $table->string('responsible_party')->change();
        });
    }
};
