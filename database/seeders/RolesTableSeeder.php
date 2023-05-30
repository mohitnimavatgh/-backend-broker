<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
            'description' => 'Is Admin',
        ]);

        DB::table('roles')->insert([
            'name' => 'user',
            'description' => 'Is User',
        ]);

        DB::table('roles')->insert([
            'name' => 'seller',
            'description' => 'Is seller',
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'role_name' => 'admin',
            'email' => 'admin123@gmail.com',
            'password' => Hash::make('admin123'),
            'visible_password' => 'admin123'
        ]);
        
    }
}
