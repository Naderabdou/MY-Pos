<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users= User::create([
            'first_name' => 'super',
            'last_name' => 'Admin',
            'email' => 'super_admin@gmail.com',
            'password' =>'123456789',

        ]);
        $users->assignRole('super_admin');

    }
}
