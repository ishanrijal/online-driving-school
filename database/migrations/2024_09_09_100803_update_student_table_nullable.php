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
            $table->string('Address')->nullable()->change();
            $table->string('DateOfBirth')->nullable()->change();
            $table->string('Gender')->nullable()->change();
            $table->string('Phone')->nullable()->change();

            $table->dropColumn('Email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('Email')->unique()->after('Phone');
            
            $table->string('Address')->nullable(false)->change();
            $table->string('DateOfBirth')->nullable(false)->change();
            $table->string('Gender')->nullable(false)->change();
            $table->string('Phone')->nullable(false)->change();
        });
    }
};
