<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'                        => 1,
            'name'                      => 'Admin',
            'email'                     => 'admin@gmail.com',
            'email_verified_at'         => null,
            'password'                  =>  bcrypt("adminbintangpermai"),
            'foto'                      => '',
            'level'                     => 1,
        ]);
    }
}
