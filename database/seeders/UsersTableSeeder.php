<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'admin_sekolah',
            'password' => Hash::make('admin_sekolah1'),
            'role' => 'admin_sekolah'
        ]);

        User::create([
            'username' => 'admin_tu',
            'password' => Hash::make('admin_tu1'),
            'role' => 'admin_tu'
        ]);

        // Add more users as needed
    }
}
