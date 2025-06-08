@extends('layouts.app')
@section('header')
    @switch($header)
        @case(str_contains($header, "index"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Tus Mangas</h1>
            @break
        @case(str_contains($header, "create"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Nuevo Manga</h1>
            @break
        @case(str_contains($header, "edit"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Editar Manga</h1>
            @break
    @endswitch
@endsection
@section('content')
    @switch($header)
        @case(str_contains($header, "index"))
            <div class="container relative mx-auto px-4 mt-4">
                <div class="flex justify-center mt-4">
                    <a href="{{ route('your_manga.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded underline">
                        Añadir Manga
                    </a>
                </div>
                <div class="overflow-x-auto py-3">
                    <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Título</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Estado de lectura</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Último capítulo leído</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Fecha de última lectura</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Añadido el:</th>
                                <th class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mangas as $manga)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white font-semibold">{{ $manga->title }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ $manga->pivot->read_status }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ $manga->pivot->last_chapter_read ?? 'Sin empezar' }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ $manga->pivot->last_read_at ? date('d M Y', strtotime($manga->pivot->last_read_at)) : 'No leído' }}</td>
                                    <td class="px-4 py-2 text-center text-gray-900 dark:text-white">{{ date('d M Y', strtotime($manga->pivot->added_at)) }}</td>
                                    <td class="px-4 py-2 ">
                                        <div class="flex gap-4 justify-center">
                                            <a href="{{ route('manga.show', $manga->id)}}" class="text-blue-500 dark:text-blue-500 font-semibold ">Detalles del manga</a>
                                            <a href="{{ route('your_manga.edit', $manga->id)}}" class="text-white dark:text-white font-semibold ">Editar</a>
                                            <form action="{{route('your_manga.destroy', $manga->id)}}" method="POST" class="inline" onsubmit="return confirmDelete();">
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
                    <form action="{{ route('your_manga.store') }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow" onsubmit="notRead()">
                        @csrf
                        <div class="mb-4">
                            <label for="manga_id" class="block text-md font-medium text-gray-700 dark:text-gray-300">Manga</label>
                            <select name="manga_id" id="manga_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" selected disabled>Selecciona un manga</option>
                                @foreach($mangas as $manga)
                                    @if ( !in_array($manga->id, $yourMangasIds))                                        
                                        <option value="{{ $manga->id }}">{{ $manga->title }}</option>
                                    @endif
                                @endforeach
                                
                                @if (count($mangas) == count($yourMangasIds))
                                    <option value="" disabled>No quedan mangas disponibles</option>
                                @endif
                            </select>
                            <a href="{{ route('manga.create') }}" class="block mt-2 text-white dark:text-white underline text-center">¿No encuentras el manga deseado? Añádelo aquí</a>
                            
                            <label for="read_status" class="block text-md font-medium text-gray-700 dark:text-gray-300">Estado de lectura</label>
                            <select name="read_status" id="read_status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" selected disabled>Selecciona un estado</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Leyendo">Leyendo</option>
                                <option value="Leido">Leído</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="last_chapter_read" class="block text-md font-medium text-gray-700 dark:text-gray-300">Último capítulo leído</label>
                            <input type="number" name="last_chapter_read" id="last_chapter_read" min="0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                    <form action="{{ route('your_manga.update', $manga->id) }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow" onsubmit="notRead()">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="manga_id" class="block text-md font-medium text-gray-700 dark:text-gray-300">Manga</label>
                            <input type="text" name="manga_id" id="manga_id" value="{{ $manga->title }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="read_status" class="block text-md font-medium text-gray-700 dark:text-gray-300">Estado de lectura</label>
                            <select name="read_status" id="read_status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="Pendiente" {{ $manga->pivot->read_status == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Leyendo" {{ $manga->pivot->read_status == 'Leyendo' ? 'selected' : '' }}>Leyendo</option>
                                <option value="Leido" {{ $manga->pivot->read_status == 'Leido' ? 'selected' : '' }}>Leído</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="last_chapter_read" class="block text-md font-medium text-gray-700 dark:text-gray-300">Último capítulo leído </label>
                            <input type="number" name="last_chapter_read" id="last_chapter_read" value="{{ $manga->pivot->last_chapter_read }}" min="0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
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
    function notRead() {
        const estado = document.getElementById('read_status');
        const ultimo_leido = document.getElementById('last_chapter_read');
        if (estado && ultimo_leido) {
            if (estado.value === 'Pendiente') {
                ultimo_leido.value = 0;
            }
        }
    }
</script>