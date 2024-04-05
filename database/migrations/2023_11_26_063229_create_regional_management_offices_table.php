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
        Schema::create('regional_management_offices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->string('name');
            $table->string('abbreviation');
            $table->string('contact_name');
            $table->string('phone');
            $table->string('email');
            $table->string('gps');
            $table->enum('status', ['0', '1'])->default('1')->comment('1->active, 0->inactive');
            $table->timestamps();
        });
        // DB::table('regional_management_offices')->insert([
        //     [
        //         'number' => 1,
        //         'name' => 'Regional Management Office',
        //         'abbreviation' => 'ROM',
        //         'status' => '1'
        //     ]

        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regional_management_offices');
    }
};
