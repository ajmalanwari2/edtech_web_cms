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
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->integer('phone_no');
            $table->enum('gender', [ 'male', 'female']);
            $table->date('dob')->nullable();
            $table->unsignedInteger('province_id');
            $table->foreign('province_id')
            ->references('id')->on('provinces')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->unsignedInteger('district_id');
            $table->foreign('district_id')
            ->references('id')->on('districts')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->unsignedInteger('school_id')->nullable();
            $table->foreign('school_id')
            ->references('id')->on('schools')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->unsignedInteger('grade_id')->nullable();
            $table->foreign('grade_id')
            ->references('id')->on('grades')
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
        Schema::dropIfExists('teachers');
    }
};
