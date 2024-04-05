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
        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->string('name');
            $table->enum('status', ['0', '1'])->default('1')->comment('1->active, 0->inactive');
            $table->integer('regional_management_office_id')->unsigned();
            $table->foreign('regional_management_office_id')
                ->references('id')->on('regional_management_offices')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
        // DB::table('provinces')->insert([
        //     [
        //         'number' => 1,
        //         'name' => 'Kabul',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 2,
        //         'name' => 'Kapisa',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 3,
        //         'name' => 'Parwan',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 4,
        //         'name' => 'Wardak',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 5,
        //         'name' => 'Logar',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 6,
        //         'name' => 'Nangarhar',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 7,
        //         'name' => 'Laghman',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 8,
        //         'name' => 'Panjsher',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 9,
        //         'name' => 'Baghlan',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 10,
        //         'name' => 'Bamyan',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 11,
        //         'name' => 'Ghazni',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 12,
        //         'name' => 'Paktya',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 13,
        //         'name' => 'Kunarha',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 14,
        //         'name' => 'Nuristan',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 15,
        //         'name' => 'Badakhshan',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 16,
        //         'name' => 'Takhar',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 17,
        //         'name' => 'Kunduz',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 18,
        //         'name' => 'Balkh',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 19,
        //         'name' => 'Samangan',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 20,
        //         'name' => 'Sar-e-Pul',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 21,
        //         'name' => 'Ghor',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 22,
        //         'name' => 'Daykundi',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 23,
        //         'name' => 'Uruzgan',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 24,
        //         'name' => 'Zabul',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 25,
        //         'name' => 'Paktika',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 26,
        //         'name' => 'Khost',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 27,
        //         'name' => 'Jawzjan',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 28,
        //         'name' => 'Faryab',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 29,
        //         'name' => 'Badghis',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 30,
        //         'name' => 'Hirat',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 31,
        //         'name' => 'Farah',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 32,
        //         'name' => 'Hilmand',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 33,
        //         'name' => 'Kandahar',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ],
        //     [
        //         'number' => 34,
        //         'name' => 'Nimroz',
        //         'status' => '1',
        //         'regional_management_office_id' => 1
        //     ]

        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
