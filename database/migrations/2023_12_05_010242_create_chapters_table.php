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
        Schema::create('chapters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->string('name');
            $table->enum('status', ['0', '1'])->default('1')->comment('1->active, 0->inactive');
            $table->enum('state', ['0', '1'])->default('0')->comment('1->active, 0->inactive');
            $table->integer('total_quiz_time');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')
            ->references('id')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->integer('grade_id')->unsigned();
            $table->foreign('grade_id')
                ->references('id')->on('grades')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedInteger('subject_id');
            $table->foreign('subject_id')
                ->references('id')->on('subjects')
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
        Schema::dropIfExists('chapters');
    }
};
