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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Slider name/title
            $table->unsignedBigInteger('video_id'); 
                $table->string('thumbnail')->nullable(); // <-- Add this line
// Link to video
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('video_id')
                  ->references('id')->on('videos')
                  
                  ->onDelete('cascade'); // Delete slider if video is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
