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
        Schema::create('course_quizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('course_id')->unsigned();
            $table->text('question_text')->nullable();
            $table->string('question_image')->nullable();
            $table->enum('difficulty_level', ['easy', 'medium','hard']);
            $table->text('option_a_text')->nullable();
            $table->string('option_a_image')->nullable();
            $table->text('option_b_text')->nullable();
            $table->string('option_b_image')->nullable();
            $table->text('option_c_text')->nullable();
            $table->string('option_c_image')->nullable();
            $table->text('option_d_text')->nullable();
            $table->string('option_d_image')->nullable();
            $table->string('references')->nullable();
            $table->enum('correct_answer', ['a', 'b', 'c', 'd']);
            $table->integer('created_by')->unsigned();
            $table->foreign('course_id')
            ->references('id')->on('courses')
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
        Schema::dropIfExists('quizes');
    }
};
