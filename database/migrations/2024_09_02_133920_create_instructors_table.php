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
        if (!Schema::hasTable('instructors')) {
            Schema::create('instructors', function (Blueprint $table) {
                $table->id('InstructorID');
                $table->string('Name');
                $table->string('LicenseNumber')->unique();
                $table->string('Phone');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('image')->nullable(); // To store the trainer's image
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
        Schema::dropIfExists('instructors');
    }
};
