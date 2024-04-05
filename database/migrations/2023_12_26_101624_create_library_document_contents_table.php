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
        Schema::create('library_document_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('library_document_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->integer('created_by')->unsigned();
            $table->foreign('library_document_id')
            ->references('id')->on('library_documents')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('created_by')
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
        Schema::dropIfExists('course__contents');
    }
};
