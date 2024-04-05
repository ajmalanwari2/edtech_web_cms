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
        Schema::create('read_notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notice_id');
            $table->integer('user_id')->unsigned();
            $table->timestamp('notice_read_datetime');
            $table->foreign('notice_id')
            ->references('id')->on('notices')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('user_id')
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
        Schema::dropIfExists('read_notices');
    }
};
