<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin user
        DB::table('users')->insert([
            'name' => 'admin',
            'identity_number' => '100-100',
            'email' => 'admin@admin.com',
            'role'=> 'admin',
            'password' => Hash::make('123456789'),
            'created_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('users')->insert([
            'name' => 'dev_admin',
            'identity_number' => '0900-245',
            'email' => 'dev_admin@admin.com',
            'role'=> 'admin',
            'password' => Hash::make('987654321'),
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }
}
