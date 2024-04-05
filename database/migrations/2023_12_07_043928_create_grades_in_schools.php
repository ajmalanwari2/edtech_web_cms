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
        Schema::create('grades_in_schools', function (Blueprint $table) {
            $table->unsignedInteger('school_id');
            $table->unsignedInteger('grade_id');
            $table->timestamp('created_at');
            $table->unsignedInteger('created_by');

            $table->foreign('school_id')
            ->references('id')->on('schools')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('grade_id')
            ->references('id')->on('grades')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('created_by')
            ->references('id')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades_in_schools');
    }
};
