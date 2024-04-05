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
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->nullable();
            $table->string('name');
            $table->enum('status', ['0', '1'])->default('1')->comment('1->active, 0->inactive');
            $table->boolean('is_center')
            ->default('0');
            $table->unsignedInteger('province_id');
            $table->foreign('province_id')
            ->references('id')->on('provinces')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
        });
        // DB::table('districts')->insert([
        //     [
        //         'name' => 'Kabul',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Deh Sabz',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Shakardara',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Paghman',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Chahar Asyab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Musayi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Bagrami',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Qarabagh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Kalakan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Mir Bacha Kot',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Guldara',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Khak-e-Jabbar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Surobi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Estalef',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Farza',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 1
        //     ],
        //     [
        //         'name' => 'Mahmud  Raqi',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 2
        //     ],
        //     [
        //         'name' => 'Nejrab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 2
        //     ],
        //     [
        //         'name' => 'Koh Band',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 2
        //     ],
        //     [
        //         'name' => 'Hisa Duwum-e-Kohestan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 2
        //     ],
        //     [
        //         'name' => 'Tagab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 2
        //     ],
        //     [
        //         'name' => 'Alasay',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 2
        //     ],
        //     [
        //         'name' => 'Hesa Awal-e-Kohestan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 2
        //     ],
        //     [
        //         'name' => 'Chaharikar',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 3
        //     ],
        //     [
        //         'name' => 'Jabalussaraj',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 3
        //     ],
        //     [
        //         'name' => 'Shinwari',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 3
        //     ],
        //     [
        //         'name' => 'Bagram',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 3
        //     ],
        //     [
        //         'name' => 'Sayd Khel',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 3
        //     ],
        //     [
        //         'name' => 'Salang',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 3
        //     ],
        //     [
        //         'name' => 'Ghorband',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 3
        //     ],
        //     [
        //         'name' => 'Koh-e-Safi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 3
        //     ],
        //     [
        //         'name' => 'Shekh  Ali',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 3
        //     ],
        //     [
        //         'name' => 'Surkhe Parsa',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 3
        //     ],
        //     [
        //         'name' => 'Maydan Shahr',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 4
        //     ],
        //     [
        //         'name' => 'Jalrez',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 4
        //     ],
        //     [
        //         'name' => 'Nerkh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 4
        //     ],
        //     [
        //         'name' => 'Hesa Awal-e- Behsud',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 4
        //     ],
        //     [
        //         'name' => 'Day Mirdad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 4
        //     ],
        //     [
        //         'name' => 'Chak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 4
        //     ],
        //     [
        //         'name' => 'Saydabad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 4
        //     ],
        //     [
        //         'name' => 'Markaze Behsud',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 4
        //     ],
        //     [
        //         'name' => 'Jaghatu',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 4
        //     ],
        //     [
        //         'name' => 'Pul-e-Alam',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 5
        //     ],
        //     [
        //         'name' => 'Khoshi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 5
        //     ],
        //     [
        //         'name' => 'Mohammad Agha',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 5
        //     ],
        //     [
        //         'name' => 'Baraki Barak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 5
        //     ],
        //     [
        //         'name' => 'Charkh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 5
        //     ],
        //     [
        //         'name' => 'Kharwar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 5
        //     ],
        //     [
        //         'name' => 'Azra',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 5
        //     ],
        //     [
        //         'name' => 'Jalalabad',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Behsud',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Surkh Rod',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Khowgiani',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Chaparhar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Rodat',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Kama',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Kuz Kunar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Dara-e-Nur',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Hesarak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Sherzad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Pachier Agam',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Deh Bala',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Kot',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Bati Kot',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Goshta',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Achin',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Shinwar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Muhmand Dara',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Lal Pur',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Nazian',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Dur Baba',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 6
        //     ],
        //     [
        //         'name' => 'Mehtarlam',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 7
        //     ],
        //     [
        //         'name' => 'Alishing',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 7
        //     ],
        //     [
        //         'name' => 'Qarghayi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 7
        //     ],
        //     [
        //         'name' => 'Alingar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 7
        //     ],
        //     [
        //         'name' => 'Daulatshah',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 7
        //     ],
        //     [
        //         'name' => 'Mowaqat Badpas',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 7
        //     ],
        //     [
        //         'name' => 'Bazarak',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 8
        //     ],
        //     [
        //         'name' => 'Shutul',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 8
        //     ],
        //     [
        //         'name' => 'Rukha',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 8
        //     ],
        //     [
        //         'name' => 'Dara',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 8
        //     ],
        //     [
        //         'name' => 'Hese- Awal',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 8
        //     ],
        //     [
        //         'name' => 'Onaba(Anawa)',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 8
        //     ],
        //     [
        //         'name' => 'Parian',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 8
        //     ],
        //     [
        //         'name' => 'Mowaqat Abshar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 8
        //     ],
        //     [
        //         'name' => 'Pul-e-khumri',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Baghlan-e-jadid',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Dahana-e-Ghory',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Dowshi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Nahrin',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Tala Wa Barfak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Khenjan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Andarab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Khwaja Hejran',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Burka',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Pule Hesar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Dih Salah',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Khost Wa Firing',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Guzargahi Nur',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Firing Wa Gharu',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 9
        //     ],
        //     [
        //         'name' => 'Bamyan',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 10
        //     ],
        //     [
        //         'name' => 'Sayghan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 10
        //     ],
        //     [
        //         'name' => 'Yakawlang',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 10
        //     ],
        //     [
        //         'name' => 'Panjab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 10
        //     ],
        //     [
        //         'name' => 'Shibar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 10
        //     ],
        //     [
        //         'name' => 'kohmard',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 10
        //     ],
        //     [
        //         'name' => 'Mowaqat Yakawlang Number 2',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 10
        //     ],
        //     [
        //         'name' => 'Waras',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 10
        //     ],
        //     [
        //         'name' => 'Ghazni',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Khwaja Umari',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Wali Muhammadi Shahid',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Waghaz',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Andar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Deh Yak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Zana Khan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Rashidan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'jaghatu',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Qarabagh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Giro',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Nawur',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Jaghuri',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'muqur',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Ab Band',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Ajrestan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Malestan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Gelan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Nawa',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 11
        //     ],
        //     [
        //         'name' => 'Gardez',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Sayid Karam',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Ahmadaba',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Zurmat',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Shawak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Wazi Zadran',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Lija Ahmad Khel',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Ali Khel (Jaji)',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Jani Khel',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Samkani',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Dand Wa Patan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Mowaqat Mirzkah',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Mowaqat Laja mangal',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 12
        //     ],
        //     [
        //         'name' => 'Asadabad',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Wata Pur',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Narang',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Sarkani',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Marawara',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Shigal Wa Shel tan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Dara-e-Pech',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Chawkay',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Khas Kunar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Dangam',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Bar Kunar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Ghazi Abad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Chapa Dara',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Nurgal',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Nari',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 13
        //     ],
        //     [
        //         'name' => 'Poruns',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 14
        //     ],
        //     [
        //         'name' => 'Mowaqat Shiltan',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 14
        //     ],
        //     [
        //         'name' => 'Mandol',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 14
        //     ],
        //     [
        //         'name' => 'Du Ab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 14
        //     ],
        //     [
        //         'name' => 'Nurgeram',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 14
        //     ],
        //     [
        //         'name' => 'Wama',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 14
        //     ],
        //     [
        //         'name' => 'Waygal',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 14
        //     ],
        //     [
        //         'name' => 'Kamdesh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 14
        //     ],
        //     [
        //         'name' => 'Barge Matal',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 14
        //     ],
        //     [
        //         'name' => 'Faiz Abad',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Yaftal-e-Sufla',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Argo',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Arghanj Khwa',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Kohestan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Raghestan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Yawan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Shahre Buzorg',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Teshkan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Darayem',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Khash',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Baharak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Shuhada',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Shighnan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Darwaz-e-Balla',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Kof Ab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Khwahan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Keshem',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Tagab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Yamgan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Jorm',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Warduj',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Ishkashem',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Darwaz payeen',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Shaki',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Koran Wa Monjan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Zebak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Wakhan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 15
        //     ],
        //     [
        //         'name' => 'Taloqan',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Hazar Sumuch',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Baharak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Bangi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Chal',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Namak Ab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Farkhar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Kalafgan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Rostaq',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Chah Ab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Yang-e-Qala',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Khwaja Bahwddin',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Dashte Qala',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Khwaja Ghar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Eshkmesh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Warsaj',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Darqad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 16
        //     ],
        //     [
        //         'name' => 'Kunduz',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 17
        //     ],
        //     [
        //         'name' => 'Imam Saheb',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 17
        //     ],
        //     [
        //         'name' => 'Qala-e-Zal',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 17
        //     ],
        //     [
        //         'name' => 'Chahar Darah',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 17
        //     ],
        //     [
        //         'name' => 'Ali Abad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 17
        //     ],
        //     [
        //         'name' => 'Khan Abad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 17
        //     ],
        //     [
        //         'name' => 'Kalbad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 17
        //     ],
        //     [
        //         'name' => 'Gultipa',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 17
        //     ],
        //     [
        //         'name' => 'Aqtash',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 17
        //     ],
        //     [
        //         'name' => 'Dasht-e-Archi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 17
        //     ],
        //     [
        //         'name' => 'Mazar-e-Sharif',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Nahr-e-Shahi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Shor Tepa',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Dawlat Abad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Balkh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Deh Dadi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Char Kent',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Marmol',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Khulm',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Kaldar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Sharak-e-Hayratan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Chahar Bolak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Chemtal',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Sholgareh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Keshendeh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Zari',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 18
        //     ],
        //     [
        //         'name' => 'Aybak',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 19
        //     ],
        //     [
        //         'name' => 'Hazrat-e-Sultan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 19
        //     ],
        //     [
        //         'name' => 'Feroz Nakhchir',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 19
        //     ],
        //     [
        //         'name' => 'Darah Suf-e-Bala',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 19
        //     ],
        //     [
        //         'name' => 'Darah Suf-e-Payin',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 19
        //     ],
        //     [
        //         'name' => 'Khuram Wa Sarbagh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 19
        //     ],
        //     [
        //         'name' => 'Ruy-e-Du Ab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 19
        //     ],
        //     [
        //         'name' => 'Sar-e-Pul',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 20
        //     ],
        //     [
        //         'name' => 'Sayad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 20
        //     ],
        //     [
        //         'name' => 'Kohestanat',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 20
        //     ],
        //     [
        //         'name' => 'Sozma Qala',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 20
        //     ],
        //     [
        //         'name' => 'Gosfandi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 20
        //     ],
        //     [
        //         'name' => 'Balkh Ab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 20
        //     ],
        //     [
        //         'name' => 'San Charak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 20
        //     ],
        //     [
        //         'name' => 'Chaghcharan',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 21
        //     ],
        //     [
        //         'name' => 'Chahar Sadra',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 21
        //     ],
        //     [
        //         'name' => 'Du Lina',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 21
        //     ],
        //     [
        //         'name' => 'Dawlat Yar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 21
        //     ],
        //     [
        //         'name' => 'Shahrak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 21
        //     ],
        //     [
        //         'name' => 'Taywarah',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 21
        //     ],
        //     [
        //         'name' => 'Pasaband',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 21
        //     ],
        //     [
        //         'name' => 'Lal Wa Sarjangal',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 21
        //     ],
        //     [
        //         'name' => 'Tolak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 21
        //     ],
        //     [
        //         'name' => 'Saghar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 21
        //     ],
        //     [
        //         'name' => 'Nili',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 22
        //     ],
        //     [
        //         'name' => 'Ashtarlay',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 22
        //     ],
        //     [
        //         'name' => 'Khadir',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 22
        //     ],
        //     [
        //         'name' => 'kiti',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 22
        //     ],
        //     [
        //         'name' => 'Shahrestan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 22
        //     ],
        //     [
        //         'name' => 'Sang-e-Takht',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 22
        //     ],
        //     [
        //         'name' => 'Kajran',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 22
        //     ],
        //     [
        //         'name' => 'Miramor',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 22
        //     ],
        //     [
        //         'name' => 'Pato',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 22
        //     ],
        //     [
        //         'name' => 'Tirin Kot',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 23
        //     ],
        //     [
        //         'name' => 'Gizab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 22
        //     ],
        //     [
        //         'name' => 'Chora',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 23
        //     ],
        //     [
        //         'name' => 'Shahid-e-Hassas',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 23
        //     ],
        //     [
        //         'name' => 'Dehrawud',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 23
        //     ],
        //     [
        //         'name' => 'Khas Uruzgan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 23
        //     ],
        //     [
        //         'name' => 'Qalat',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Arghandab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Mizan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Tarnak Wa Jaldak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Shinkay',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Shah Joy',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Kakar (Khaak Afghan)',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Day chopan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Atghar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Shomulzay',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Naw Bahar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 24
        //     ],
        //     [
        //         'name' => 'Sharan',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Mata Khan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Yosuf Khel',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Sar Hawzeh(Rawzeh)',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Zarghun Shahr',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Yahya Khel',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Omna',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Gomal',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Sarobi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Urgun',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Naka(Nika)',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Jani Khel',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Waza Khah',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Wor Mamay',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Bermel (Burmul)',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Gian',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Ziruk',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Dila',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Turwo (Tarwe)',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 25
        //     ],
        //     [
        //         'name' => 'Khost(Matun)',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Sabari',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Musa Khel',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Nadir Shah Kot',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Mando Zayi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Tani',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Gurbuz',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Terzayi (Alisher)',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Qalandar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Shamal (shamul)',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Spera',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Bak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Jaji Maydan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 26
        //     ],
        //     [
        //         'name' => 'Shiberghan',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Mingajik',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Khwaja Do koh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Qosh Tepa',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Fayz Abad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Khanaqa',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Aqcha',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Mardyan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Qarqin',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Khamyab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Darz Ab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 27
        //     ],
        //     [
        //         'name' => 'Maymana',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Khwaja Sabz Posh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Pashtun Kot',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Shirin Tagab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Almar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Qaysar',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Kohestan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Gurziwan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Bil Cheragh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Dawlat Abad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Andkhoy',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Qaram Qol',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Khan-e-Char Bagh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Qorghan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 28
        //     ],
        //     [
        //         'name' => 'Qala-e-Naw',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 29
        //     ],
        //     [
        //         'name' => 'Muqur',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 29
        //     ],
        //     [
        //         'name' => 'Ab-e-Kamari',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 29
        //     ],
        //     [
        //         'name' => 'Qadis',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 29
        //     ],
        //     [
        //         'name' => 'Jawand',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 29
        //     ],
        //     [
        //         'name' => 'Murghab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 29
        //     ],
        //     [
        //         'name' => 'Ghormach Mowaqat',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 29
        //     ],
        //     [
        //         'name' => 'Herat',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Injil',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Kushk',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Zinda Jan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Guzra',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Pashtun  Zarghun',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Karukh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Gulran',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Ghoryan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Adraskan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Farsi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Obe',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Kushk-e-kohna',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Kohsan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => ' Mowaqat Shindan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Mowaqat Zirko',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Mowaqat Zawol',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Mowaqat Kohzrah',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Mowaqat Posht-koh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Chisht-e-Sharif',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 30
        //     ],
        //     [
        //         'name' => 'Farah',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Bakwa',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Bala Buluk',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Khak-e-Safed',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Pusht Rod',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Qala-e-Kah',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Shib Koh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Lash-e-Juwayn',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Gulestan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Pur Chaman',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Anar Dara',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 31
        //     ],
        //     [
        //         'name' => 'Lashkar Gah',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Nahr-e-Saraj',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Nad-e-Ali',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Nawa-e-Barak Zaiy',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Sangin',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Musa Qaleh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Naw Zad',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Wa sher',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Garm ser',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Kajaki',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Baghran',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Reg',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Deh shu',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Mowaqat Marjah',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 32
        //     ],
        //     [
        //         'name' => 'Kandahar',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Arghandab',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Zheray',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Panj Wayi',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Daman',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Shah Wali Kot',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Khakrez',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Maywand',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Reg',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Shor Abak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Spin Boldak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Arghestan',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Miyanshin',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Nesh',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Ghorak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Maruf',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Mowaqat Dand',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Mowaqat Takhtpol',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 33
        //     ],
        //     [
        //         'name' => 'Zaranj',
        //         'status' => '1',
        //         'is_center' => true,
        //         'province_id' => 34
        //     ],
        //     [
        //         'name' => 'Kang',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 34
        //     ],
        //     [
        //         'name' => 'Chahar Burjak',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 34
        //     ],
        //     [
        //         'name' => 'Chakhansur',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 34
        //     ],
        //     [
        //         'name' => 'Khash Rod',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 34
        //     ],
        //     [
        //         'name' => 'Mowaqat Delaram',
        //         'status' => '1',
        //         'is_center' => false,
        //         'province_id' => 34
        //     ]
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
