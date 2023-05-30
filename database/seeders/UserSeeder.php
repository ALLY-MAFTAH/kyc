<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'mobile' => '0620650411',
                'status' => true,
                'email' => 'admin@kmc.com',
                'password' => Hash::make('123'),
            ],
        );

        // User::create(
        //     [
        //         'name' => 'Market Manager',
        //         'mobile' => '0714871033',
        //         'market_id' => 1,
        //         'email' => 'manager@kmc.go.tz',
        //         'password' => Hash::make('123'),
        //     ],
        // );
    }
}
