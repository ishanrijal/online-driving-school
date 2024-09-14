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
        Schema::table('instructors', function (Blueprint $table) {
            // Modify LicenseNumber and Phone to be nullable
            $table->string('LicenseNumber')->nullable()->change();
            $table->string('Phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instructors', function (Blueprint $table) {
            // Revert LicenseNumber to be not nullable and unique
            $table->string('LicenseNumber')->nullable(false)->unique()->change();
            $table->string('Phone')->nullable(false)->change();
        });
    }
};
