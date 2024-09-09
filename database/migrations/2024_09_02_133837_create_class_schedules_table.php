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
        if (!Schema::hasTable('class_schedules')) {
            Schema::create('class_schedules', function (Blueprint $table) {
                $table->id('ClassScheduleID');
                $table->date('Date');
                $table->time('Time');
                $table->string('Location');
                $table->foreignId('InstructorID')->constrained('instructors')->onDelete('cascade');
                $table->foreignId('CourseID')->constrained('courses')->onDelete('cascade');
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
        Schema::dropIfExists('class_schedules');
    }
};
