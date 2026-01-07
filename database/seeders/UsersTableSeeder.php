<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run():void
    {
        User::create([
            'name' => 'Kenza',
            'email' => 'kenza@gmail.com',
            'password' => Hash::make('motdepasse123'), // Toujours hasher le mot de passe !
        ]);
        User::create([
            'name' => 'Nour',
            'email' => 'Nour@gmail.com',
            'password' => Hash::make('Nour123'), // Toujours hasher le mot de passe !
        ]);
    }
}
