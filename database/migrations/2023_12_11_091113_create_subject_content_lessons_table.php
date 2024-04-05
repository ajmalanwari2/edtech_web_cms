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
        Schema::create('subject_lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('chapter_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->enum('type', ['video', 'audio', 'file', 'text', 'picture'])->default('text');
            $table->integer('created_by')->unsigned();
            $table->foreign('chapter_id')
            ->references('id')->on('chapters')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                $table->softDeletes();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_lessons');
    }
};
