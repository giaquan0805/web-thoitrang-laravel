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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->string('name', 255);
            $table->string('tag', 50)->default('MỚI')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('thumbnail_url', 255)->nullable();
            $table->string('ai_clean_image_url', 255)->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
