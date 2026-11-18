<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tribhakti.com'],
            [
                'name' => 'Administrator',
                'phone' => '081234567890',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]
        );
    }
}
