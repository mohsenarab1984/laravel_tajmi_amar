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

        User::factory()->create([
            'name' => '  آقای ساور   ',
            'username' => 'user1',
            'role'=>'  معاون برنامه ریزی ',
            'password'=>Hash::make('user1'),
            'is_admin'=>0
        ]);
        User::factory()->create([
            'name' => ' آقای انسانی ',
            'username' => 'user2',
            'role'=>'  معاون  توسعه انسانی  ',
            'password'=>Hash::make('user2'),
            'is_admin'=>0
        ]);
        User::factory()->create([
            'name' => '  دامداری ',
            'username' => 'user3',
            'role'=>'  معاونت امور دام   ',
            'password'=>Hash::make('user3'),
            'is_admin'=>0
        ]);
    }
}
