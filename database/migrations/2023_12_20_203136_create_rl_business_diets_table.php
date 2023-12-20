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
        Schema::create('rl_business_diets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('business_id')->unsigned();
            $table->unsignedBiginteger('diet_id')->unsigned();
            $table->foreign('business_id')->references('id')
                ->on('businesses')->onDelete('cascade');
            $table->foreign('diet_id')->references('id')
                ->on('diets')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_business_diets');
    }
};
