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
        Schema::table('students', function (Blueprint $table) {
            // Remove LicenseNumber column
            $table->dropColumn('LicenseNumber');
            
            // Add Address column and other necessary information
            $table->string('Address')->after('Name');
            $table->date('DateOfBirth')->nullable()->after('Address');
            $table->enum('Gender', ['Male', 'Female', 'Other'])->nullable()->after('DateOfBirth');
            $table->string('image')->nullable()->after('Gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Add back LicenseNumber column
            $table->string('LicenseNumber')->unique()->after('Name');
            
            // Remove newly added columns
            $table->dropColumn('Address');
            $table->dropColumn('DateOfBirth');
            $table->dropColumn('Gender');
            $table->dropColumn('image');
        });
    }
};