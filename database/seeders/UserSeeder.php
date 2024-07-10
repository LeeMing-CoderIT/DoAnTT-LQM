<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \DB::table('users')->insert([
        //     [
        //         'email' => 'lequyminh101@gmail.com',
        //         'password' => bcrypt('12345'),
        //         'fullname' => 'Lê Quí Minh 1',
        //         'root' => 1,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'email' => 'lequyminh102@gmail.com',
        //         'password' => bcrypt('12345'),
        //         'fullname' => 'Lê Quí Minh 2',
        //         'root' => -1,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'email' => 'lequyminh1013@gmail.com',
        //         'password' => bcrypt('12345'),
        //         'fullname' => 'Lê Quí Minh 3',
        //         'root' => 0,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'email' => 'lequyminh104@gmail.com',
        //         'password' => bcrypt('12345'),
        //         'fullname' => 'Lê Quí Minh 4',
        //         'root' => 0,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'email' => 'lequyminh105@gmail.com',
        //         'password' => bcrypt('12345'),
        //         'fullname' => 'Lê Quí Minh 5',
        //         'root' => 0,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ]
        // ]);
        \DB::table('setting_users')->insert([
            [
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
