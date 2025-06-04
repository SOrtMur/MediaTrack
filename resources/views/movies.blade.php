@extends('layouts.app')
@section('header')
    @switch($header)
        @case(str_contains($header, "index"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Lista de Películas</h1>
            @break
        @case(str_contains($header, "show"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Detalles de la Película</h1>
            @break
        @break
        @case(str_contains($header, "create"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Nueva Película</h1>
            @break
        @case(str_contains($header, "edit"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Editar Película</h1>
            @break
    @endswitch
@endsection
@section('content')
    @switch($header)
        @case(str_contains($header, "index"))
            <div class="container relative mx-auto px-4 mt-4">
                <div class="flex justify-center mt-4">
                    <a href="{{ route('movie.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded underline">
                        Añadir Película
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-md md:max-w-xl lg:max-w-full py-3">
                    @foreach ($movies as $movie)
                        <div class=" flex flex-col justify-center bg-white dark:bg-gray-800 rounded-lg shadow p-4 mx-auto object-contain">
                            <img src="{{ $movie->img_path  }}" alt="{{ $movie->title }}" class="rounded-md mb-4" width="340px" height="200px">
                            <div class="flex justify-center mb-2">
                                <h2 class="text-lg font-semibold text-white">{{ $movie->title }}</h2>
                            </div>
                            <div class="flex justify-between mt-2 mb-2 align-end">
                                <a href="{{ route('movie.show', $movie->id)}}" class="text-white font-semibold underline">Ver detalles</a>
                                <a href="{{ route('movie.edit', $movie->id)}}" class="text-white font-semibold underline">Editar</a>
                                <form action="{{route('movie.destroy', $movie->id)}}" method="POST" class="text-white font-semibold">
                                    @csrf
                                    @method("DELETE")
                                    <input type="submit" value="Borrar" class="btn btn-info underline"/>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @break
        @case(str_contains($header, "show"))
            <div class="container mx-auto px-4 py-8 mt-4 ">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h2 class="text-2xl text-white font-bold text-center">{{ $movie->title }}</h2>
                    <div class="mt-4 flex gap-4 justify-center items-center max-w-sm md:max-w-md lg:max-w-lg mx-auto">
                        <img src="{{ $movie->img_path }}" alt="{{ $movie->title }}" class="object-contain rounded-md mb-4" width="50%" height="auto">
                        <div class="flex flex-col justify-center text-md md:text-base lg:text-xl">
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Fecha de estreno: </span>{{ date('d M Y', strtotime($movie->release_date)) }}</p>
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Descripción: </span>{{ $movie->description }}</p>
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Valoración media: </span>{{ $movie->avg_rate }}</p>
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Duración: </span>{{ $movie->duration }} minutos.</p>
                        </div>
                        {{-- Posibilida de añadir un link al buscador de peliculas con $movie->title --}}
                    </div>
                </div>
            </div>
            @break
        @case(str_contains($header, "create"))
            <div class="container mx-auto px-4 py-8 mt-4">
                <div class="flex-row justify-center">
                    <form action="{{ route('movie.store') }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-md font-medium text-gray-700 dark:text-gray-300">Título</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="release_date" class="block text-md font-medium text-gray-700 dark:text-gray-300">Fecha de estreno</label>
                            <input type="date" name="release_date" id="release_date" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-md font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="img_path" class="block text-md font-medium text-gray-700 dark:text-gray-300">URL Imagen</label>
                            <input type="url" name="img_path" id="img_path" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="duration" class="block text-md font-medium text-gray-700 dark:text-gray-300">Duración (minutos)</label>
                            <input type="number" name="duration" id="duration" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="avg_rate" class="block text-md font-medium text-gray-700 dark:text-gray-300">Valoración media</label>
                            <input type="number" name="avg_rate" id="avg_rate" step="0.1" min="0" max="10" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            @break
        @case(str_contains($header, "edit"))
            <h1>Editar Película</h1>
            {{-- Formulario de edicion de pelicula --}}
            <div class="container mx-auto px-4 py-8 mt-4">
                <div class="flex-row justify-center">
                    <form action="{{ route('movie.update', $movie->id) }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title" class="block text-md font-medium text-gray-700 dark:text-gray-300">Título</label>
                            <input type="text" name="title" id="title" value="{{ $movie->title }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="release_date" class="block text-md font-medium text-gray-700 dark:text-gray-300">Fecha de estreno</label>
                            <input type="date" name="release_date" id="release_date" value="{{ $movie->release_date }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-md font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $movie->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="img_path" class="block text-md font-medium text-gray-700 dark:text-gray-300">URL Imagen</label>
                            <input type="url" name="img_path" id="img_path" value="{{ $movie->img_path }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="duration" class="block text-md font-medium text-gray-700 dark:text-gray-300">Duración (minutos)</label>
                            <input type="number" name="duration" id="duration" value="{{ $movie->duration }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="avg_rate" class="block text-md font-medium text-gray-700 dark:text-gray-300">Valoración media</label>
                            <input type="number" name="avg_rate" id="avg_rate" step="0.1" min="0" max="10" value="{{ $movie->avg_rate }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Editar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @break
    @endswitch
@endsection