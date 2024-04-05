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
        Schema::table('library_document_contents', function (Blueprint $table) {
            $table->enum('is_main', ['0', '1'])->default('0')->comment('1->yes, 0->no')->after('body');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('library_document_contents', function (Blueprint $table) {
            $table->dropColumn('is_main');
        });
    }
};
