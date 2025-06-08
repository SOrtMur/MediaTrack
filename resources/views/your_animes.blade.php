@extends('layouts.app')
@section('header')
    @switch($header)
        @case(str_contains($header, "index"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Tus Animes</h1>
            @break
        @case(str_contains($header, "create"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Nuevo Anime</h1>
            @break
        @case(str_contains($header, "edit"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Editar Anime</h1>
            @break
    @endswitch
@endsection
@section('content')
    @switch($header)
        @case(str_contains($header, "index"))
            <div class="container relative mx-auto px-4 mt-4">
                <div class="flex justify-center mt-4">
                    <a href="{{ route('your_anime.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded underline">
                        Añadir Anime
                    </a>
                </div>
                <div class="overflow-x-auto py-3">
                    <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Título</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Estado de visionado</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Último capítulo visto</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Visto por última vez</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Añadida el</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($animes as $anime)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white font-semibold">{{ $anime->title }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ $anime->pivot->watched_status }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ $anime->pivot->last_episode_watched }} </td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ $anime->pivot->last_watched_date ? date('d M Y', strtotime($anime->pivot->last_watched_date)) : 'No Visto' }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ date('d M Y', strtotime($anime->pivot->added_at)) }}</td>
                                    <td class="px-4 py-2 ">
                                        <div class="flex gap-4 justify-center">
                                            <a href="{{ route('anime.show', $anime->id)}}" class="text-blue-500 dark:text-blue-500 font-semibold ">Detalles de la pelicula</a>
                                            <a href="{{ route('your_anime.edit', $anime->id)}}" class="text-white dark:text-white font-semibold ">Editar</a>
                                            <form action="{{route('your_anime.destroy', $anime->id)}}" method="POST" class="inline" onsubmit="return confirmDelete();">
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
                    <form action="{{ route('your_anime.store') }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow" onsubmit="notWatched()">
                        @csrf
                        <div class="mb-4">
                            <label for="anime_id" class="block text-md font-medium text-gray-700 dark:text-gray-300">Anime</label>
                            <select name="anime_id" id="anime_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" selected disabled>Selecciona un anime</option>
                                @foreach($animes as $anime)
                                    @if ( !in_array($anime->id, $yourAnimesIds))                                        
                                        <option value="{{ $anime->id }}">{{ $anime->title }}</option>
                                    @endif
                                @endforeach
                                
                                @if (count($animes) == count($yourAnimesIds))
                                    <option value="" disabled>No quedan animes disponibles</option>
                                @endif
                            </select>
                            <a href="{{ route('anime.create') }}" class="block mt-2 text-white dark:text-white underline text-center">¿No encuentras el anime deseado? Añádelo aquí</a>
                            
                            <label for="watched_status" class="block text-md font-medium text-gray-700 dark:text-gray-300">Estado de visionado</label>
                            <select name="watched_status" id="watched_status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" selected disabled>Selecciona un estado</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Viendo">Viendo</option>
                                <option value="Visto">Visto</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="last_episode_watched" class="block text-md font-medium text-gray-700 dark:text-gray-300">Último capítulo visto</label>
                            <input type="number" name="last_episode_watched" id="last_episode_watched" value="0" min="0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
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
                    <form action="{{ route('your_anime.update', $anime->id) }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow" onsubmit="notWatched()">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="anime_id" class="block text-md font-medium text-gray-700 dark:text-gray-300">Anime</label>
                            <input type="text" name="anime_id" id="anime_id" value="{{ $anime->title }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="watched_status" class="block text-md font-medium text-gray-700 dark:text-gray-300">Estado de visionado</label>
                            <select name="watched_status" id="watched_status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="Pendiente" {{ $anime->pivot->watched_status == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Viendo" {{ $anime->pivot->watched_status == 'Viendo' ? 'selected' : '' }}>Viendo</option>
                                <option value="Visto" {{ $anime->pivot->watched_status == 'Visto' ? 'selected' : '' }}>Visto</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="last_episode_watched" class="block text-md font-medium text-gray-700 dark:text-gray-300">Último capítulo visto</label>
                            <input type="number" name="last_episode_watched" id="last_episode_watched" value="{{ $anime->pivot->last_episode_watched }}" min="0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
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
        return confirm('¿Estás seguro de eliminar esta anime?');
    }
    function notWatched() {
        const estado = document.getElementById('watched_status');
        const ultimoVisto = document.getElementById('last_episode_watched');
        if (estado && ultimoVisto) {
            if (estado.value === 'Pendiente') {
                ultimoVisto.value = 0;
            }
        }
    }
</script>