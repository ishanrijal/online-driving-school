<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
                $table->id('StudentID');
                $table->string('Name');
                $table->string('LicenseNumber')->unique();
                $table->string('Phone');
                $table->string('Email')->unique();
                $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade')->onUpdate('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};