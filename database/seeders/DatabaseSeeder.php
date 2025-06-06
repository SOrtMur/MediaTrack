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

        //Seedear los animes
        DB::table('animes')->insert([
            [
                'title' => 'Attack on Titan',
                'description' => 'En un mundo donde la humanidad vive dentro de enormes muros para protegerse de gigantes devoradores de humanos, Eren Yeager se une a la Legión de reconocimiento para luchar contra los titanes.',
                'release_date' => '2013-04-07',
                'episodes' => 25,
                'status' => 'Finalizado',
                'avg_score' => 9.0,
                'img_path' => 'https://m.media-amazon.com/images/I/713JPi6+CkL.jpg',
            ],
            [
                'title' => 'My Hero Academia',
                'description' => 'En un mundo donde la mayoría de las personas tienen superpoderes, Izuku Midoriya, un niño sin poderes, sueña con convertirse en un héroe.',
                'release_date' => '2016-04-03',
                'episodes' => 88,
                'status' => 'En emisión',
                'avg_score' => 8.5,
                'img_path' => 'https://static.wikia.nocookie.net/bokunoheroacademia/images/9/9c/Season_7_Poster_3.png',
            ],
            [
                'title' => 'Demon Slayer: Kimetsu no Yaiba',
                'description' => 'Tanjiro Kamado, un joven que se convierte en cazador de demonios para vengar a su familia y curar a su hermana Nezuko, quien se ha convertido en un demonio.',
                'release_date' => '2019-04-06',
                'episodes' => 26,
                'status' => 'Finalizado',
                'avg_score' => 8.7,
                'img_path' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTU34kLG8mnBb4Hf62Etepld95zC_l-Xid6wQ&s',
            ],
        ]);
        //Seedear los mangas
        DB::table('mangas')->insert([
            [
                'title' => 'One Piece',
                'description' => 'La historia sigue a Monkey D. Luffy y su tripulación de piratas en su búsqueda del tesoro más grande del mundo, el One Piece.',
                'release_date' => '1997-07-22',
                'chapters' => 1000,
                'status' => 'En emisión',
                'avg_score' => 9.5,
                'img_path' => 'https://m.media-amazon.com/images/I/81+6b1k2JpL.jpg',
            ],
            [
                'title' => 'Naruto',
                'description' => 'Naruto Uzumaki, un joven ninja con el sueño de convertirse en Hokage, lucha por ganarse el respeto de su aldea.',
                'release_date' => '1999-09-21',
                'chapters' => 700,
                'status' => 'Finalizado',
                'avg_score' => 8.8,
                'img_path' => 'https://m.media-amazon.com/images/I/71+4d3e2yXL.jpg',
            ],
            [
                'title' => 'Death Note',
                'description' => 'Un estudiante de secundaria encuentra un cuaderno que le permite matar a cualquier persona cuyo nombre escriba en él.',
                'release_date' => '2003-01-02',
                'chapters' => 108,
                'status' => 'Finalizado',
                'avg_score' => 9.2,
                'img_path' => 'https://m.media-amazon.com/images/I/81+4d3e2yXL.jpg',
            ],
        ]);
        //Seedear los juegos
        DB::table('games')->insert([
            [
                'title' => 'The Legend of Zelda: Breath of the Wild',
                'description' => 'Un juego de acción y aventura en un mundo abierto donde Link debe derrotar a Calamity Ganon.',
                'release_date' => '2017-03-03',
                'avg_score' => 9.7,
                'img_path' => 'https://m.media-amazon.com/images/I/81+4d3e2yXL.jpg',
            ],
            [
                'title' => 'The Witcher 3: Wild Hunt',
                'description' => 'Un juego de rol de acción en un mundo abierto donde Geralt de Rivia busca a su hija adoptiva Ciri.',
                'release_date' => '2015-05-19',
                'avg_score' => 9.5,
                'img_path' => 'https://m.media-amazon.com/images/I/81+4d3e2yXL.jpg',
            ],
            [
                'title' => 'God of War (2018)',
                'description' => 'Un juego de acción y aventura donde Kratos y su hijo Atreus deben enfrentarse a los dioses nórdicos.',
                'release_date' => '2018-04-20',
                'avg_score' => 9.4,
                'img_path' => 'https://m.media-amazon.com/images/I/81+4d3e2yXL.jpg',
            ],
        ]);

    }
}
