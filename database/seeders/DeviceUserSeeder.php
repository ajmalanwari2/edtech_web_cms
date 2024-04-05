<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DeviceUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'mobile',
            'identity_number' => '0900-300',
            'email' => 'mobile@learning.com',
            'role'=> 'admin',
            'password' => Hash::make('K3N$lWg9@'),
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('users')->insert([
            'name' => 'front-end',
            'identity_number' => '0900-200',
            'email' => 'front-end@learning.com',
            'role'=> 'admin',
            'password' => Hash::make('K3N$lWg9@'),
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }
}
