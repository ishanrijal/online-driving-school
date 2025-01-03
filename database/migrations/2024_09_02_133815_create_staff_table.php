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
        if (!Schema::hasTable('staff')) {
            Schema::create('staff', function (Blueprint $table) {
                $table->id('StaffID');
                $table->string('Name');
                $table->string('Phone')->nullable();
                $table->string('Address')->nullable();
                $table->string('Gender')->nullable();
                $table->string('DateOfBirth')->nullable();
                $table->string('image')->nullable();
                $table->foreignId('AdminID')->nullable()->constrained('admins', 'AdminID')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('staff');
    }
};
