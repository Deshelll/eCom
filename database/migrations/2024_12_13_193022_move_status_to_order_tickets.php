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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('order_tickets', function (Blueprint $table) {
            $table->string('status')->default('Не оплачено');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('Не оплачено');
        });

        Schema::table('order_tickets', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
