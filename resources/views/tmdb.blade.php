@extends('layouts.app')
@section('header')
    @switch($header)
        @case('index')
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Películas Encontradas</h1>
            @break
        @case('show')
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Detalles de la Película</h1>
            @break            
    @endswitch
@endsection
@section('content')
    @switch($header)
        @case('index')
        <div class="container mx-auto px-4 pt-16 mt-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-8 gap-3">
                    @if (count($movies) === 0)
                        <div class="col-span-8 text-center text-gray-500 dark:text-gray-400">
                            <p>No se encontraron películas para la búsqueda.</p>
                            <p>Intenta con otro término de búsqueda.</p>
                        </div>
                    @endif
                    @foreach ($movies as $movie)
                        <div class="mt-8 relative">
                            <a href="{{ route('tmdb.show', $movie['id']) }}">
                                <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'] }}" class="hover:opacity-50 transition ease-in-out duration-150 rounded-lg"/>
                            </a>
                            <span class="ml-3 mt-3 border-2 border-yellow-500 rounded-full w-8 h-8 text-center absolute top-0 left-0 text-white font-semibold text-sm flex justify-center items-center">
                                {{ $movie['vote_average'] * 10 }} <small class="text-xs">%</small>
                            </span>
                            <div class="mt-2">
                                <a href="{{ route('tmdb.show', $movie['id']) }}" class="text-md pt-4 text-white font-semibold hover:text-yellow-500">{{ $movie['title'] }}</a>
                                <div class="flex items-center text-gray-400 text-sm">
                                    <span>{{ $movie['release_date'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>                  
            </div>            
        </div>
        
        @break
        {{-- @case('show')
            <div class="container mx-auto px-4 pt-16">
                <div class="flex flex-col md:flex-row">
                    <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="w-full md:w-1/3 rounded-lg mb-4 md:mb-0">
                    <div class="md:ml-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $movie['title'] }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $movie['overview'] }}</p>
                        <div class="mt-4">
                            <span class="text-yellow-500 font-semibold">{{ $movie['vote_average'] * 10 }}%</span>
                            <span class="text-gray-500 ml-4">{{ $movie['release_date'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Información Adicional</h3>
                    <ul class="list-disc pl-5 mt-2 text-gray-600 dark:text-gray-400">
                        <li><strong>Géneros:</strong> {{ implode(', ', array_column($movie['genres'], 'name')) }}</li>
                        <li><strong>Duración:</strong> {{ $movie['runtime'] }} minutos</li>
                        <li><strong>Idioma Original:</strong> {{ $movie['original_language'] }}</li>
                    </ul>
                </div>
            </div> --}}

        @case(str_contains($header, "show"))
        <div class="container mx-auto px-4 py-8 mt-4 ">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h2 class="text-2xl text-white font-bold text-center">{{ $movie['title'] }}</h2>
                <div class="mt-4 flex gap-4 justify-center items-center max-w-sm md:max-w-md lg:max-w-lg mx-auto">
                    <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="object-contain rounded-md mb-4" width="50%" height="auto">
                    <div class="flex flex-col justify-center text-md md:text-base lg:text-xl">
                        <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Fecha de estreno: </span>{{ date('d M Y', strtotime($movie['release_date'])) }}</p>
                        <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Descripción: </span>{{ $movie['overview'] }}</p>
                        <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Valoración media: </span>{{ $movie['vote_average'] * 10 }}%</p>
                        <ul class="list-disc pl-5 mt-2 text-gray-600 dark:text-gray-400">
                            <li><strong>Géneros:</strong> {{ implode(', ', array_column($movie['genres'], 'name')) }}</li>
                            <li><strong>Duración:</strong> {{ $movie['runtime'] }} minutos</li>
                            <li><strong>Idioma Original:</strong> {{ $movie['original_language'] }}</li>
                        </ul>
                        <div class="flex justify-center mt-4">
                            @php
                                $request = [
                                    'title' => $movie['title'],
                                    'img_path' => 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'],
                                    'description' => $movie['overview'],
                                    'release_date' => $movie['release_date'],
                                    'avg_rate' => $movie['vote_average'] * 10,
                                    'duration' => $movie['runtime'],
                                ];
                            @endphp
                            <form method="POST" action="{{ route('movie.store') }}" class="flex items-center space-x-4">
                                @csrf
                                <input type="hidden" name="title" value="{{ $request['title'] }}">
                                <input type="hidden" name="img_path" value="{{ $request['img_path'] }}">
                                <input type="hidden" name="description" value="{{ $request['description'] }}">
                                <input type="hidden" name="release_date" value="{{ $request['release_date'] }}">
                                <input type="hidden" name="avg_rate" value="{{ $request['avg_rate'] }}">
                                <input type="hidden" name="duration" value="{{ $request['duration'] }}">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                    Añadir a películas
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @break
            @break
        @endswitch
@endsection