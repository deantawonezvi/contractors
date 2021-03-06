<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        \App\User::create([
            'id' => 1,
            'organisation_id' => 1,
            'name' => 'Org',
            'role'=>'organisation',
            'email' => 'org@og.com',
            'password' => bcrypt('123456')
        ]);

        \App\User::create([
            'id' => 4,
            'organisation_id' => 1,
            'name' => 'Org Finance',
            'role'=>'finance',
            'email' => 'finance@og.com',
            'password' => bcrypt('123456')
        ]);

        \App\User::create([
            'id' => 2,
            'sub_contractor_id' => 1,
            'name' => 'Sub',
            'role'=>'sub_contractor',
            'email' => 'sub@sub.com',
            'password' => bcrypt('123456')
        ]);

        \App\User::create([
            'id' => 3,
            'name' => 'Admin',
            'role'=>'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);


    }
}
