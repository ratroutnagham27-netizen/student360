<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            [
                'name'     => 'Admin Demo',
                'email'    => 'admin@student360.test',
                'password' => 'password',
                'role'     => UserRole::ADMIN,
            ],
            [
                'name'     => 'Teacher Demo',
                'email'    => 'teacher@student360.test',
                'password' => 'password',
                'role'     => UserRole::TEACHER,
            ],
            [
                'name'     => 'Parent Demo',
                'email'    => 'parent@student360.test',
                'password' => 'password',
                'role'     => UserRole::PARENT,
            ],
        ];

        foreach ($accounts as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}