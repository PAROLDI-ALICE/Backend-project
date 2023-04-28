<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('guard_name')->default('patient');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->string('guard_name')->default('admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('guard_name')->default('patient');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropcolumn('guard_name')->default('admin');
        });
    }
};
