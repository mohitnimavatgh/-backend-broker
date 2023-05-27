<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        
    }
}
