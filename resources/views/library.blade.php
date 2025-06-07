@extends('layouts.app')
@section('header')
        <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Tu Biblioteca Personal</h1>
        <p class="text-center text-gray-600 dark:text-gray-400 mt-2">Aquí puedes gestionar tus animes, juegos, mangas y películas.</p>
@endsection
@section('content')
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Animes</h2>
                    <p class="text-gray-600 dark:text-gray-400">Gestiona tus animes, añade nuevos, elimina los que no quieras. </p>
                    <a href="/library/animes" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ver Animes</a>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Juegos</h2>
                    <p class="text-gray-600 dark:text-gray-400">Gestiona tus juegos, añade nuevos, elimina los que no quieras.</p>
                    <a href="/library/games" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ver Juegos</a>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Mangas</h2>
                    <p class="text-gray-600 dark:text-gray-400">Gestiona tus mangas, añade nuevos, elimina los que no quieras.</p>
                    <a href="/library/mangas" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ver Mangas</a>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Películas</h2>
                    <p class="text-gray-600 dark:text-gray-400">Gestiona tus películas, añade nuevas, elimina las que no quieras.</p>
                    <a href="{{route('your_movie.index')}}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ver Películas</a>
                </div>
            </div>
        </div>
@endsection