<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Alsaeyd J Alakhras',
            'email' => 'alsaeydjalkhras@gmail.com',
            'password'  => '20051118Jamal',
            'username'  => 'saeyd_jamal',
            'last_activity'  => now(),
            'avatar'  => null,
            'super_admin'  => 1,
        ]);
    }
}
