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
            ['email' => 'admin@admin.com'],
            [
                'name'      => 'Admin',
                'password'  => Hash::make('password'),
                'nick'      => 'admin',
                'status'    => 'active',
                'user_type' => 'admin',
                'level'     => 'admin',
            ]
        );
    }
}