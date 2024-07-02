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
        User::create([
            'full_name' => 'Gustavo Delgado',
            'email' => 'gdquevedo@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'full_name' => 'Alejandra Valenzuela',
            'email' => 'aleval@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::factory(10)->create();
    }
}
