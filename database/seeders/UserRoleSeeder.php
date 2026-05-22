<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'phone' => '080000000001',
                'password' => '@admin123',
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'owner@gmail.com'],
            [
                'name' => 'Owner Kelompok Tani',
                'phone' => '080000000002',
                'password' => '@owner123',
                'role' => 'owner',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'buyer@gmail.com'],
            [
                'name' => 'Pembeli',
                'phone' => '080000000003',
                'password' => '@buyer123',
                'role' => 'buyer',
                'status' => 'active',
            ]
        );
    }
}