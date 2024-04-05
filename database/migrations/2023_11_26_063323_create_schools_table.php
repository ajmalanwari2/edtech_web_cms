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
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->string('name');
            $table->enum('status', ['0', '1'])->default('1')->comment('1->active, 0->inactive');
            $table->integer('regional_management_office_id')->unsigned();
            $table->foreign('regional_management_office_id')
                ->references('id')->on('regional_management_offices')
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
            $table->timestamps();
            $table->integer('created_by')->unsigned();
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
        Schema::dropIfExists('schools');
    }
};
