<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->id();
            $table->date('specific_date')->nullable();
            $table->integer('week_day');
            $table->time('open_time_1');
            $table->time('close_time_1');
            $table->time('open_time_2')->nullable();
            $table->time('close_time_2')->nullable();
            $table->foreignId('business_id')->constrained('businesses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opening_hours');
    }
};
