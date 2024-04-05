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
        Schema::create('student_in_parents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_parent_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('created_by');

            $table->foreign('student_parent_id')
            ->references('id')->on('student_parents')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('student_id')
            ->references('id')->on('students')
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
        Schema::dropIfExists('student_in_parents');
    }
};
