<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'type' => '1',
                'password' => bcrypt('123456'),
            ], 
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'type' => '0',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($user as $key => $user) {
            User::create($user);
        }
    }
}
