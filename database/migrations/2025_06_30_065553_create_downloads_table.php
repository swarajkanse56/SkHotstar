<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('video_id')
                ->constrained('videos') // explicitly mention the table name
                ->onDelete('cascade');

            // Download metadata
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_size');
            $table->timestamp('downloaded_at')->useCurrent();

            $table->timestamps();

            // Ensure one unique download per user per video
            $table->unique(['user_id', 'video_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('downloads');
    }
};
