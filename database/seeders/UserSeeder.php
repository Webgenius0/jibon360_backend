<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'phone' => '01775567491',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ],
            [
                'name' => 'Moderator',
                'email' => 'moderator@moderator.com',
                'phone' => '01775567492',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'moderator',
            ],
            [
                'name' => 'User',
                'email' => 'user@user.com',
                'phone' => '01775567493',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'user',
            ],
        ]);
    }
}
