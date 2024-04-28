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
        Schema::table('subject_lessons', function (Blueprint $table) {
            $table->bigInteger('file_size')->default(0)->after('body');
        });
        Schema::table('course_contents', function (Blueprint $table) {
            $table->bigInteger('file_size')->default(0)->after('body');
        });
        Schema::table('library_document_contents', function (Blueprint $table) {
            $table->bigInteger('file_size')->default(0)->after('body');
        });
        Schema::table('library_kit_contents', function (Blueprint $table) {
            $table->bigInteger('file_size')->default(0)->after('body');
        });
        Schema::table('library_audio_contents', function (Blueprint $table) {
            $table->bigInteger('file_size')->default(0)->after('body');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subject_lessons', function (Blueprint $table) {
            $table->dropColumn('file_size');
        });
        Schema::table('course_contents', function (Blueprint $table) {
            $table->dropColumn('file_size');
        });
        Schema::table('library_document_contents', function (Blueprint $table) {
            $table->dropColumn('file_size');
        });
        Schema::table('library_kit_contents', function (Blueprint $table) {
            $table->dropColumn('file_size');
        });
        Schema::table('library_audio_contents', function (Blueprint $table) {
            $table->dropColumn('file_size');
        });
    }
};
