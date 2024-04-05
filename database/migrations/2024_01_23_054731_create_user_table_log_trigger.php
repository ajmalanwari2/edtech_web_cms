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
        Schema::create('user_logs', function (Blueprint $table) {
            $table->string('name');
            $table->string('identity_number');
            $table->string('email');
            $table->string('profile_image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', [ 'admin', 'teacher','student', 'parent','guest'])->default('guest');
            $table->enum('status', ['0', '1'])->default('1')->comment('1->active, 0->inactive');
            $table->timestamp('last_seen')->nullable();
            $table->timestamp('requested_date')->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::unprepared('
        CREATE TRIGGER `user_log_taker` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
	    IF (NEW.name != OLD.name ||
	    NEW.identity_number != OLD.identity_number ||
	    NEW.email != OLD.email ||
	    NEW.profile_image != OLD.profile_image ||
	    NEW.email_verified_at != OLD.email_verified_at ||
	    NEW.password != OLD.password ||
	    NEW.role != OLD.role ||
        NEW.status != OLD.status ||
	    NEW.requested_date != OLD.requested_date ||
        NEW.remember_token != OLD.remember_token
	    ) THEN

        INSERT INTO user_logs
        (name, identity_number, email, profile_image, email_verified_at, password, `role`, status, requested_date, remember_token)
        VALUES(OLD.name, OLD.identity_number, OLD.email, OLD.profile_image, OLD.email_verified_at, OLD.password, OLD.role, OLD.status, OLD.requested_date, OLD.remember_token);
	    END IF;
    END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_logs');
        DB::unprepared('DROP TRIGGER `student_log_taker`');
    }
};
