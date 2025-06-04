<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Insertar roles por defecto
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

        //Crear el usuario admin
        User::create([
            'name' => "admin",
            'email' => "admin@example.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        //Añadir al usuario admin al rol de administrador
        User::find(1)->role()->attach(1);

        //Seedear las peliculas
        DB::table('movies')->insert([
            [
                'title' => 'Inception',
                'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.',
                'duration' => 148,
                'release_date' => '2010-07-16',
                'avg_rate' => 8.8,
                'img_path' => 'https://4ddig.tenorshare.com/images/photo-recovery/images-not-found.jpg',
            ],
            [
                'title' => 'The Dark Knight',
                'description' => 'When the menace known as the Joker emerges from his mysterious past, he wreaks havoc and chaos on the people of Gotham.',
                'duration' => 152,
                'release_date' => '2008-07-18',
                'avg_rate' => 9.0,
                'img_path' => 'https://m.media-amazon.com/images/M/MV5BMTMxNTMwODM0NF5BMl5BanBnXkFtZTcwODAyMTk2Mw@@._V1_.jpg',
            ],
            [
                'title' => 'Interstellar',
                'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'duration' => 169,
                'release_date' => '2014-11-07',
                'avg_rate' => 8.6,
                'img_path' => 'https://pics.filmaffinity.com/Interstellar-366875261-large.jpg',
            ],
        ]);

    }
}
