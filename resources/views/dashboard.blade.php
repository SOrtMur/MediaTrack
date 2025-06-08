@extends('layouts.app')
@section('header')
    <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Página de Inicio</h1>
@endsection
@section('content')
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Bienvenido a MediaTracker</h2>
            <p class="text-gray-600 dark:text-gray-400">Aquí puedes gestionar tu biblioteca personal de animes, juegos, mangas y películas.</p>
            <p class="mt-4 text-gray-600 dark:text-gray-400">Utiliza el menú de navegación para acceder a las diferentes secciones.</p>
        </div>
    </div>
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Tu Biblioteca Personal</h2>
                <p class="text-gray-600 dark:text-gray-400">Gestiona tus animes, juegos, mangas y películas.</p>
                <a href="/library" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ir a la Biblioteca</a>
            </div>
        </div>
    </div>
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Buscador de Películas y Juegos</h2>
                <p class="text-gray-600 dark:text-gray-400">Explora y encuentra información sobre tus películas y juegos favoritos utilizando nuestro buscador especializado.</p>
                <a href="/search" class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ir al Buscador</a>
            </div>
        </div>
    </div>
@endsection