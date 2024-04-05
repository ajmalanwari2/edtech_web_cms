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
        Schema::create('library_video_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('library_video_id');
            $table->integer('user_id')->unsigned();
            $table->enum('state', ['0', '1'])->default('0')->comment('1->active, 0->inactive');
            $table->foreign('library_video_id')
            ->references('id')->on('library_videos')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('user_id')
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
        Schema::dropIfExists('library_video_bookmarks');
    }
};
