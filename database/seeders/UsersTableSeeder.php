<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       

        DB::table('users')->insert([
            //Admin
            [
               'name'=>'Admin',
               'username'=>'Admin',
               'email'=>'Admin@gmail.com',
               'password'=>Hash::make('12345678'),
               'role'=>'admin',
               'status'=>'active',
            ],
            [
                'name'=>'Vendor',
                'username'=>'Vendor',
                'emai'=>'Vendor@gmail.com',
                'password'=>Hash::make('12345678'),
                'role'=>'vendor',
                'status'=>'active',
            ],  
             [
                'name'=>'User',
                'username'=>'User',
                'emai'=>'User@gmail.com',
                'password'=>Hash::make('12345678'),
                'role'=>'user',
                'status'=>'active',
            ]
            

        ]);
    }
}
