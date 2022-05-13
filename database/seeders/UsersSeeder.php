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
                    'name' => 'Ziat Adil',
                    'email' => 'admin@demo.com',
                    'password' => $password,
                ],
            1 =>
                [
                    'id' => 2,
                    'name' => 'Barbara J. Glanz',
                    'email' => 'manager@demo.com',
                    'password' => $password,
                ],
            2 =>
                [
                    'id' => 3,
                    'name' => 'Charles W. Abeyta',
                    'email' => 'client@demo.com',
                    'password' => $password,
                ],
            3 =>
                [
                    'id' => 4,
                    'name' => 'Robert E. Brock',
                    'email' => 'client1@demo.com',
                    'password' => $password,
                ],
            4 =>
                [
                    'id' => 5,
                    'name' => 'Sanchez Roberto',
                    'email' => 'driver@demo.com',
                    'password' => $password,
                ],
            5 =>
                [
                    'id' => 6,
                    'name' => 'John Doe',
                    'email' => 'driver1@demo.com',
                    'password' => $password,
                ],
        ]);
    }
}
