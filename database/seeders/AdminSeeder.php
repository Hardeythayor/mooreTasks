<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Abstract9 Admin',
            'email' => 'admin@abstract9.com',
            'password' => bcrypt(12345678),
            'phone' => '07059836078',
            'user_type' => 'admin',
            'status' => 'active'
        ]);
    }
}
