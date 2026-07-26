<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@warungpakdo.test'],
            [
                'name' => 'Pak Do',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer@warungpakdo.test'],
            [
                'name' => 'Budi',
                'password' => 'password',
                'role' => 'customer',
            ]
        );
    }
}
