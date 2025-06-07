@extends('layouts.app')
@section('header')
    @switch($header)
        @case(str_contains($header, "index"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Tus Películas</h1>
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
                    <a href="{{ route('your_movie.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded underline">
                        Añadir Película
                    </a>
                </div>
                <div class="overflow-x-auto py-3">
                    <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Título</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Estado de visionado</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Tiempo visto</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Añadida el:</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($movies as $movie)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white font-semibold">{{ $movie->title }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ $movie->pivot->watched_status }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ $movie->pivot->watched_time }} minutos</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ date('d M Y', strtotime($movie->pivot->added_at)) }}</td>
                                    <td class="px-4 py-2 ">
                                        <div class="flex gap-4 justify-center">
                                            <a href="{{ route('movie.show', $movie->id)}}" class="text-blue-500 dark:text-blue-500 font-semibold ">Detalles de la pelicula</a>
                                            <a href="{{ route('your_movie.edit', $movie->id)}}" class="text-white dark:text-white font-semibold ">Editar</a>
                                            <form action="{{route('your_movie.destroy', $movie->id)}}" method="POST" class="inline" onsubmit="return confirmDelete();">
                                                @csrf
                                                @method("DELETE")
                                                <input type="submit" value="Borrar" class="text-red-600 dark:text-red-400 font-semibold bg-transparent border-none cursor-pointer"/>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @break
        @case(str_contains($header, "create"))
            <div class="container mx-auto px-4 py-8 mt-4">
                <div class="flex-row justify-center">
                    <form action="{{ route('your_movie.store') }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow" onsubmit="notWatched()">
                        @csrf
                        <div class="mb-4">
                            <label for="movie_id" class="block text-md font-medium text-gray-700 dark:text-gray-300">Película</label>
                            <select name="movie_id" id="movie_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" selected disabled>Selecciona una película</option>
                                @foreach($movies as $movie)
                                    @if ( !in_array($movie->id, $yourMoviesIds))                                        
                                        <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                                    @endif
                                @endforeach
                                
                                @if (count($movies) == count($yourMoviesIds))
                                    <option value="" disabled>No quedan películas disponibles</option>
                                @endif
                            </select>
                            <a href="{{ route('movie.create') }}" class="block mt-2 text-white dark:text-white underline text-center">¿No encuentras la pelicula deseada? Añádela aquí</a>
                            
                            <label for="watched_status" class="block text-md font-medium text-gray-700 dark:text-gray-300">Estado de visionado</label>
                            <select name="watched_status" id="watched_status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" selected disabled>Selecciona un estado</option>
                                <option value="No_vista">No vista</option>
                                <option value="Viendo">Viendo</option>
                                <option value="Vista">Vista</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="watched_time" class="block text-md font-medium text-gray-700 dark:text-gray-300">Tiempo visto (minutos)</label>
                            <input type="number" name="watched_time" id="watched_time" min="0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded border">
                                Añadir a tu biblioteca
                            </button>
                        </div>
                    </form>
                </div>
            @break
        @case(str_contains($header, "edit"))
            <div class="container mx-auto px-4 py-8 mt-4">
                <div class="flex-row justify-center">
                    <form action="{{ route('your_movie.update', $movie->id) }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow" onsubmit="notWatched()">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="movie_id" class="block text-md font-medium text-gray-700 dark:text-gray-300">Película</label>
                            <input type="text" name="movie_id" id="movie_id" value="{{ $movie->title }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="watched_status" class="block text-md font-medium text-gray-700 dark:text-gray-300">Estado de visionado</label>
                            <select name="watched_status" id="watched_status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="No_vista" {{ $movie->pivot->watched_status == 'No_vista' ? 'selected' : '' }}>No vista</option>
                                <option value="Viendo" {{ $movie->pivot->watched_status == 'Viendo' ? 'selected' : '' }}>Viendo</option>
                                <option value="Vista" {{ $movie->pivot->watched_status == 'Vista' ? 'selected' : '' }}>Vista</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="watched_time" class="block text-md font-medium text-gray-700 dark:text-gray-300">Tiempo visto (minutos)</label>
                            <input type="number" name="watched_time" id="watched_time" value="{{ $movie->pivot->watched_time }}" min="0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded border">
                                Editar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @break
    @endswitch
@endsection

<script>
    function confirmDelete() {
        return confirm('¿Estás seguro de eliminar esta película?');
    }
    function notWatched() {
        const estado = document.getElementById('watched_status');
        const tiempo = document.getElementById('watched_time');
        if (estado && tiempo) {
            if (estado.value === 'No_vista') {
                tiempo.value = 0;
            }
        }
    }
</script>