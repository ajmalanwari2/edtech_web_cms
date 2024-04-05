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
        Schema::create('student_tracking_chapters', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('chapter_id');
            $table->integer('student_id')->unsigned();
            $table->foreign('chapter_id')
            ->references('id')->on('chapters')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('student_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->datetime('chapter_start_date')->nullable();
            $table->datetime('chapter_end_date')->nullable();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_tracking_chapters');
    }
};
