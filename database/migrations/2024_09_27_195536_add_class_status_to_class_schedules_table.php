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
        Schema::table('class_schedules', function (Blueprint $table) {
            Schema::table('class_schedules', function (Blueprint $table) {
                $table->enum('class_status', ['confirmed', 'pending', 'cancelled'])->default('pending'); // Adding the class_status column
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_schedules', function (Blueprint $table) {
            Schema::table('class_schedules', function (Blueprint $table) {
                $table->dropColumn('class_status'); // Dropping the class_status column
            });
        });
    }
};
