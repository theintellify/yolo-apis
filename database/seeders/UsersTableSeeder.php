<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'darshak@theintellify.com',
                'password'       => bcrypt('mLwY8c9%Sf2F'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
