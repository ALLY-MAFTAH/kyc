<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'KYC Admin',
                'email' => 'admin@kmc.com',
                'password' => Hash::make('123'),
            ],
        );

        User::create(
            [
                'name' => 'KYC Staff',
                'email' => 'staff@kmc.com',
                'password' => Hash::make('123'),
            ],
        );
    }
}
