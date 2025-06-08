@extends('layouts.app')
@section('header')
    @switch($header)
        @case(str_contains($header, "index"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Tus Juegos</h1>
            @break
        @case(str_contains($header, "create"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Nuevo Juego</h1>
            @break
        @case(str_contains($header, "edit"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Editar Juego</h1>
            @break
    @endswitch
@endsection
@section('content')
    @switch($header)
        @case(str_contains($header, "index"))
            <div class="container relative mx-auto px-4 mt-4">
                <div class="flex justify-center mt-4">
                    <a href="{{ route('your_game.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded underline">
                        Añadir Juego
                    </a>
                </div>
                <div class="overflow-x-auto py-3">
                    <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Título</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Estado de juego</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Tiempo jugado</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Jugado por ultima vez</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Añadido el:</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($games as $game)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white font-semibold">{{ $game->title }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ $game->pivot->played_status }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ $game->pivot->played_time }} horas</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">
                                        @if ($game->pivot->last_played_at == null)
                                            <span class="text-gray-500 dark:text-gray-400">Nunca jugado</span>
                                        @else
                                            {{ date('d M Y', strtotime($game->pivot->last_played_at)) }}
                                        @endif
                                            
                                    </td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ date('d M Y', strtotime($game->pivot->added_at)) }}</td>
                                    <td class="px-4 py-2 ">
                                        <div class="flex gap-4 justify-center">
                                            <a href="{{ route('game.show', $game->id)}}" class="text-blue-500 dark:text-blue-500 font-semibold ">Detalles del juego</a>
                                            <a href="{{ route('your_game.edit', $game->id)}}" class="text-white dark:text-white font-semibold ">Editar</a>
                                            <form action="{{route('your_game.destroy', $game->id)}}" method="POST" class="inline" onsubmit="return confirmDelete();">
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
                    <form action="{{ route('your_game.store') }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow" onsubmit="notPlayed()">
                        @csrf
                        <div class="mb-4">
                            <label for="game_id" class="block text-md font-medium text-gray-700 dark:text-gray-300">Juego</label>
                            <select name="game_id" id="game_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" selected disabled>Selecciona un juego</option>
                                @foreach($games as $game)
                                    @if ( !in_array($game->id, $yourGamesIds))                                        
                                        <option value="{{ $game->id }}">{{ $game->title }}</option>
                                    @endif
                                @endforeach
                                
                                @if (count($games) == count($yourGamesIds))
                                    <option value="" disabled>No quedan juegos disponibles</option>
                                @endif
                            </select>
                            <a href="{{ route('game.create') }}" class="block mt-2 text-white dark:text-white underline text-center">¿No encuentras el juego deseado? Añádelo aquí</a>
                            
                            <label for="played_status" class="block text-md font-medium text-gray-700 dark:text-gray-300">Estado de juego</label>
                            <select name="played_status" id="played_status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" selected disabled>Selecciona un estado</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Jugando">Jugando</option>
                                <option value="Finalizado">Finalizado</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="played_time" class="block text-md font-medium text-gray-700 dark:text-gray-300">Tiempo jugado (horas)</label>
                            <input type="number" name="played_time" id="played_time" min="0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
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
                    <form action="{{ route('your_game.update', $game->id) }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow" onsubmit="notPlayed()">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="game_id" class="block text-md font-medium text-gray-700 dark:text-gray-300">Juego</label>
                            <input type="text" name="game_id" id="game_id" value="{{ $game->title }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="played_status" class="block text-md font-medium text-gray-700 dark:text-gray-300">Estado de juego</label>
                            <select name="played_status" id="played_status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="Pendiente" {{ $game->pivot->played_status == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Jugando" {{ $game->pivot->played_status == 'Jugando' ? 'selected' : '' }}>Jugando</option>
                                <option value="Finalizado" {{ $game->pivot->played_status == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="played_time" class="block text-md font-medium text-gray-700 dark:text-gray-300">Tiempo jugado (horas)</label>
                            <input type="number" name="played_time" id="played_time" value="{{ $game->pivot->played_time }}" min="0" step=".1" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
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
        return confirm('¿Estás seguro de eliminar este juego?');
    }
    function notPlayed() {
        const estado = document.getElementById('played_status');
        const tiempo = document.getElementById('played_time');
        if (estado && tiempo) {
            if (estado.value === 'Pendiente') {
                tiempo.value = 0;
            }
        }
    }
</script>