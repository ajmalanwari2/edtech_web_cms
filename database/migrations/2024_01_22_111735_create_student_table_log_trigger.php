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
        Schema::create('student_logs', function (Blueprint $table) {
            // $table->increments('id');
            $table->integer('phone_no');
            $table->enum('gender', [ 'male', 'female']);
            $table->date('dob')->nullable();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::unprepared('
        CREATE TRIGGER `student_log_taker` BEFORE UPDATE ON `students` FOR EACH ROW BEGIN
	    IF (NEW.phone_no != OLD.phone_no ||
	    NEW.gender != OLD.gender ||
	    NEW.dob != OLD.dob ||
	    NEW.user_id != OLD.user_id ||
	    NEW.province_id != OLD.province_id ||
	    NEW.district_id != OLD.district_id ||
	    NEW.school_id != OLD.school_id ||
	    NEW.grade_id != OLD.grade_id
	    ) THEN
	        INSERT INTO student_logs (phone_no,gender,dob,user_id,province_id,district_id,school_id,grade_id)
	       values(OLD.phone_no,OLD.gender,OLD.dob,OLD.user_id,OLD.province_id,OLD.district_id,OLD.school_id,OLD.grade_id);
	    END IF;
    END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_logs');
        DB::unprepared('DROP TRIGGER `student_log_taker`');

    }
};
