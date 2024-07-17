<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'password'=>Hash::make('admin'),
            'is_admin'=>1
        ]);
        User::factory()->create([
            'name' => 'user',
            'username' => 'user',
            'password'=>Hash::make('user'),
            'is_admin'=>0
        ]);
        User::factory()->create([
            'name' => 'رِییس  ',
            'username' => 'boss',
            'role'=>'رییس سازمان',
            'password'=>Hash::make('boss'),
            'is_admin'=>0
        ]);
    }
}
