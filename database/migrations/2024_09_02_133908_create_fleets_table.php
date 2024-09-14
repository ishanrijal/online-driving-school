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
        if (!Schema::hasTable('fleet')) {
            Schema::create('fleet', function (Blueprint $table) {
                $table->id('FleetID');
                $table->string('VehicleNumber')->unique();
                $table->string('Model');
                $table->string('Status');
                $table->foreignId('BranchID')->constrained('branches', 'BranchID')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('fleet');
    }
};
