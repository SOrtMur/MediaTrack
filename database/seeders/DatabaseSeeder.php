<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'admin' => 'Administrador del sistema',
            'user' => 'Usuario del sistema',
            'content manager' => 'Gestor de contenido',
        ];

        foreach ($roles as $key => $value) {
            Role::create([
                'name' => $key,
                'description' => $value,
            ]);
        }

        User::create([
            'name' => "admin",
            'email' => "admin@example.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        User::find(1)->role()->attach(1);
    }
}
