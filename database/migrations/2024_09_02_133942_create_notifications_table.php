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
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id('NotificationID');
                $table->date('Date');
                $table->string('Message');
                $table->foreignId('AdminID')->constrained('admins', 'AdminID')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('notifications');
    }
};
