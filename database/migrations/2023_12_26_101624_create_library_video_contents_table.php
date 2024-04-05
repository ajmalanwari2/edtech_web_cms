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
        Schema::create('library_video_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('library_video_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->integer('created_by')->unsigned();
            $table->foreign('library_video_id')
            ->references('id')->on('library_videos')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course__contents');
    }
};
