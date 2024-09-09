<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary(); // Session ID
                $table->foreignId('user_id')->nullable()->constrained('users', 'user_id')->onDelete('cascade'); // Foreign key to users table
                $table->string('ip_address', 45)->nullable(); // IP Address
                $table->text('user_agent')->nullable(); // User Agent
                $table->longText('payload'); // Session Data
                $table->integer('last_activity')->index(); // Last Activity Timestamp

                // Optional: Adding indexes for faster queries
                $table->index('user_id');
                $table->index('last_activity');
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
        Schema::dropIfExists('sessions');
    }
}