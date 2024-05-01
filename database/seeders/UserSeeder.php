<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nadim Sheikh',
            'email' => 'nadim.sheikh.07@gmail.com',
            'password' => bcrypt('Abcd@1234'),
        ]);
    }
}
