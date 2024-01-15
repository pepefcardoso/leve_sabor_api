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
        Schema::create('rl_blog_post_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('blog_post_id')->unsigned();
            $table->unsignedBiginteger('blog_post_category_id')->unsigned();
            $table->foreign('blog_post_id')->references('id')->on('blog_posts')->onDelete('cascade');
            $table->foreign('blog_post_category_id')->references('id')->on('blog_post_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rl_blog_post_categories');
    }
};
