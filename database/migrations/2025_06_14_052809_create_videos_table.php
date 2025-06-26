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
    Schema::create('videos', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('thumbnail')->nullable();  // thumbnail image path
        $table->string('video_url');              // video file path or streaming URL
        $table->unsignedBigInteger('category_id')->nullable();    // category for this video
        $table->unsignedBigInteger('subcategory_id')->nullable(); // subcategory (optional)

        $table->text('description')->nullable();  // optional description
        $table->integer('duration')->nullable();  // duration in seconds, optional

        $table->timestamps();

        // Foreign keys
        $table->foreign('category_id')
              ->references('id')->on('categories')
              ->onDelete('set null');

        $table->foreign('subcategory_id')
              ->references('id')->on('subcategories')
              ->onDelete('set null');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
