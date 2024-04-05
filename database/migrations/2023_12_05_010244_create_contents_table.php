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
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->string('name');
            $table->text('description');
            $table->string('type');
            $table->enum('status', ['0', '1'])->default('1')->comment('1->active, 0->inactive');
            $table->string('path');
            $table->unsignedInteger('chapter_id');
            $table->foreign('chapter_id')
            ->references('id')->on('chapters')
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
        Schema::dropIfExists('contents');
    }
};
