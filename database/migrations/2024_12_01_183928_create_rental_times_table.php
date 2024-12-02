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
        Schema::create('rental_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_card_id')->constrained()->onDelete('cascade');
            $table->time('start_time');
            $table->boolean('is_booked')->default(false);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_times');
    }
};
