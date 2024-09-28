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
        Schema::table('staff', function (Blueprint $table) {
            Schema::table('staff', function (Blueprint $table) {
                // Add user_id column as a foreign key to the users table
                $table->unsignedBigInteger('user_id')->nullable(); // Assuming the user_id can be nullable
                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            });

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            Schema::table('staff', function (Blueprint $table) {
                // Drop the foreign key and column
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        });
    }
};
