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
        Schema::table('student_profiles', function (Blueprint $table) {
            // Remove the Address column
            $table->dropColumn('Address');
            $table->dropColumn('LicenseInfo');

            $table->renameColumn('Date', 'CourseEnrollDate');

            // Add CourseID as a foreign key referencing courses table
            $table->unsignedBigInteger('CourseID')->after('StudentID'); // Adjust position if necessary
            $table->foreign('CourseID')->references('CourseID')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            // Re-add the Address column
            $table->string('Address')->nullable(); // or appropriate type based on your needs
            $table->string('LicenseInfo')->nullable(); // or appropriate type based on your needs

            $table->renameColumn('CourseEnrollDate', 'Date');
            
            // Drop the foreign key and CourseID column
            $table->dropForeign(['CourseID']);
            $table->dropColumn('CourseID');
        });
    }
};
