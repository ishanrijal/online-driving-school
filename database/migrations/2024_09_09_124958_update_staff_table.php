<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff', function (Blueprint $table) {
            // Remove the 'Role' and 'Email' columns
            $table->dropColumn('Role');
            $table->dropColumn('Email');

            // Add 'Phone', 'Address', and 'Gender' columns
            $table->string('Phone')->nullable()->after('AdminID');
            $table->string('Address')->nullable()->after('Phone');
            $table->string('Gender')->nullable()->after('Address');
            $table->string('DateOfBirth')->nullable()->after('Gender');
            $table->string('AdminID')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff', function (Blueprint $table) {
            // Add back the 'Role' and 'Email' columns
            $table->string('Role');
            $table->string('Email')->unique();

            // Remove the 'Phone', 'Address', and 'Gender' columns
            $table->dropColumn(['Phone', 'Address', 'Gender', 'DateOfBirth']);

            $table->string('DateOfBirth')->nullable(false)->change();
        });
    }
}