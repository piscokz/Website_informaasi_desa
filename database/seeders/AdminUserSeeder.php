<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // cari pakai email
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'), // default password: "password"
            ]
        );
    }
}
