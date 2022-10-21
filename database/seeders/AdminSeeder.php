<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Moore Advice',
            'email' => 'admin@mooretask.com',
            'password' => bcrypt(12345678),
            'phone' => '07059836078',
            'user_type' => 'admin',
            'status' => 'active'
        ]);
    }
}
