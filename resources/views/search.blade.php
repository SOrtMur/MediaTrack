@extends('layouts.app')

@php
    $header = 'search';
@endphp
@section('header')
    <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Buscadores de Películas y Juegos</h1>
@endsection

@section('content')
    <div class="container relative mx-auto px-4 py-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Buscador de Películas</h2>
            <div class="flex justify-center mb-4">
                <figure class="flex flex-col items-center mb-4">
                    <img src="https://imgs.search.brave.com/8zzwXOpgWtvKbUK52RFAqPTqP6trL7ugCAbcyqRkC8Q/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9hLmx0/cmJ4ZC5jb20vaW1n/L2VkaXRvcmlhbC90/bWRiLTIwMjAuc3Zn" alt="TMDB Logo" width="400px" class="mb-4">
                    <figcaption class="sm:text-sm md:text-basis text-gray-500 dark:text-gray-300 text-center">
                        La información de películas es proporcionada por 
                        <a href="https://www.themoviedb.org/" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-blue-400 underline hover:text-blue-800 dark:hover:text-blue-200">
                            The Movie Database (TMDB)
                        </a>. This product uses the TMDB API but is not endorsed or certified by TMDB. 
                        TMDB es una base de datos comunitaria de películas y series, donde los usuarios pueden contribuir información, imágenes y reseñas. 
                        Ofrece una API gratuita para desarrolladores, permitiendo acceder a datos actualizados sobre películas, actores, géneros y más. 
                        Para más información o para contribuir, visita 
                        <a href="https://www.themoviedb.org/about" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-blue-400 underline hover:text-blue-800 dark:hover:text-blue-200">
                            Acerca de TMDB
                        </a>.
                    </figcaption>
                </figure>
            </div>
            <form method="POST" action=" {{ route('tmdb.index') }}" class="flex items-center space-x-4">
                @csrf
                <input type="text" id="pelicula" name="pelicula" placeholder="Buscar películas por nombre" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" required>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Buscar</button>
            </form>
        </div> 
    </div>
    <div class="container relative mx-auto px-4 py-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Buscador de Juegos</h2>
            <h3 class="text-basic font-semibold text-gray-900 dark:text-red-400 mb-4">Esta funcionalidad no está inplementada, pues se necesitaria de un OAuth para poder utilizar la API de IGDB. Lo sentimos.</h3>
            <figure class="flex flex-col items-center mb-4">
                <img src="https://miro.medium.com/v2/resize:fit:1200/1*DpaeArqM7JWzJLylsVl9lg.png" alt="IGDB Logo" width="400px" class="mb-4">
                <figcaption class="sm:text-sm md:text-basis text-gray-500 dark:text-gray-300 text-center">
                    La información de juegos es proporcionada por 
                    <a href="https://www.igdb.com/" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-blue-400 underline hover:text-blue-800 dark:hover:text-blue-200">
                        IGDB (Internet Game Database)
                    </a>. Este producto utiliza la API de IGDB pero no está avalado ni certificado por IGDB.<br>
                    IGDB es una base de datos comunitaria de videojuegos, donde los usuarios pueden contribuir información, imágenes y reseñas. 
                    Ofrece una API gratuita para desarrolladores, permitiendo acceder a datos actualizados sobre juegos, plataformas, géneros y más.<br>
                    Para más información o para contribuir, visita 
                    <a href="https://www.igdb.com/about" target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-blue-400 underline hover:text-blue-800 dark:hover:text-blue-200">
                        Acerca de IGDB
                    </a>.
                </figcaption>
            </figure>
            <form method="POST" action="" class="flex items-center space-x-4" onsubmit="event.preventDefault();">
                <input type="text" name="query" placeholder="Buscar juegos por nombre" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" required>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Buscar</button>
            </form>
        </div> 
    </div>
@endsection
