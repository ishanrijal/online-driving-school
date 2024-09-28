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
        Schema::table('payments', function (Blueprint $table) {
            Schema::table('payments', function (Blueprint $table) {
                // Make the InvoiceID column nullable
                $table->unsignedBigInteger('InvoiceID')->nullable()->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            Schema::table('payments', function (Blueprint $table) {
                // Revert the InvoiceID column back to not nullable if needed
                $table->unsignedBigInteger('InvoiceID')->nullable(false)->change();
            });
        });
    }
};
