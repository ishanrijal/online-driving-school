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
        Schema::table('courses', function (Blueprint $table) {
            Schema::table('courses', function (Blueprint $table) {
                // Make AdminID nullable
                $table->unsignedBigInteger('AdminID')->nullable()->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            Schema::table('courses', function (Blueprint $table) {
                // Revert the nullable change
                $table->unsignedBigInteger('AdminID')->nullable(false)->change();
            });
        });
    }
};