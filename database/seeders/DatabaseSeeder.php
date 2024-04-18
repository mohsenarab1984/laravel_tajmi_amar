<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call([
            
        // ]);
        // \App\Models\User::factory(100)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'password'=>Hash::make('admin'),
            'is_admin'=>1
        ]);
        \App\Models\User::factory()->create([
            'name' => 'user',
            'username' => 'user',
            'password'=>Hash::make('user'),
            'is_admin'=>0
        ]);
    }
}
