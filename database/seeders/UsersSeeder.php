<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make("123456");

        \DB::table('users')->delete();

        \DB::table('users')->insert([
            0 =>
                [
                    'id' => 1,
                    'username' => 'ziat_adil',
                    'first_name' => 'Adil',
                    'last_name' => 'Ziat',
                    'phone' => '',
                    'address' => '',
                    'email' => 'admin@demo.com',
                    'password' => $password,
                ],
            1 =>
                [
                    'id' => 2,
                    'username' => 'barbara_glanz',
                    'first_name' => 'Glanz',
                    'last_name' => 'Barbara',
                    'phone' => '',
                    'address' => '',
                    'email' => 'manager@demo.com',
                    'password' => $password,
                ],
            2 =>
                [
                    'id' => 3,
                    'username' => 'charles_Abeyta',
                    'first_name' => 'Abeyta',
                    'last_name' => 'W. Charles',
                    'phone' => '',
                    'address' => '',
                    'email' => 'client@demo.com',
                    'password' => $password,
                ],
            3 =>
                [
                    'id' => 4,
                    'username' => 'robert_brock',
                    'first_name' => 'Robert',
                    'last_name' => 'Brock',
                    'phone' => '',
                    'address' => '',
                    'email' => 'client1@demo.com',
                    'password' => $password,
                ],
            4 =>
                [
                    'id' => 5,
                    'username' => 'sanchez_roberto',
                    'first_name' => 'Sanchez',
                    'last_name' => 'Roberto',
                    'phone' => '',
                    'address' => '',
                    'email' => 'driver@demo.com',
                    'password' => $password,
                ],
            5 =>
                [
                    'id' => 6,
                    'username' => 'john_doe',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'phone' => '',
                    'address' => '',
                    'email' => 'driver1@demo.com',
                    'password' => $password,
                ],
        ]);
    }
}
