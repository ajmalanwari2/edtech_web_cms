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
        Schema::create('deleted_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('identity_number')->unique();
            $table->string('last_name')->nullable();
            $table->string('father_name')->nullable();
            $table->enum('gender', [ 'male', 'female']);
            $table->date('dob')->nullable();
            $table->string('email', 191);
            $table->integer('phone_no');
            $table->enum('role', [ 'admin', 'teacher','student', 'parent','guest'])->default('guest');
            $table->integer('is_approved')->nullable()->default(NULL);
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
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_users');
    }
};
