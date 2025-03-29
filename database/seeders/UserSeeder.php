<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Farmer Alex',
                'email' => 'alex@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'GreenGuru',
                'email' => 'guru@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

