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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->integer('total_questions');
            $table->integer('total_correct_answers');
            $table->string('time_taken');
            $table->enum('state', ['0', '1'])->default('0')->comment('1->active, 0->inactive');

            $table->integer('chapter_id')->unsigned();
            $table->integer('student_id')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
