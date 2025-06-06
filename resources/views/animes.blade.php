@extends('layouts.app')
@section('header')
    @switch($header)
        @case(str_contains($header, "index"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Lista de Animes</h1>
            @break
        @case(str_contains($header, "show"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Detalles del Anime</h1>
            @break
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
                    <a href="{{ route('anime.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded underline">
                        Añadir Anime
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-md md:max-w-xl lg:max-w-full py-3">
                    @foreach ($animes as $anime)
                        <div class=" flex flex-col justify-center bg-white dark:bg-gray-800 rounded-lg shadow p-4 mx-auto object-contain">
                            <img src="{{ $anime->img_path  }}" alt="{{ $anime->title }}" class="rounded-md mb-4" width="340px" height="200px">
                            <div class="flex justify-center mb-2">
                                <h2 class="text-lg font-semibold text-white">{{ $anime->title }}</h2>
                            </div>
                            <div class="flex justify-between mt-2 mb-2 align-end">
                                <a href="{{ route('anime.show', $anime->id)}}" class="text-white font-semibold underline">Ver detalles</a>
                                <a href="{{ route('anime.edit', $anime->id)}}" class="text-white font-semibold underline">Editar</a>
                                <form action="{{route('anime.destroy', $anime->id)}}" method="POST" class="text-white font-semibold" onsubmit="return confirmDelete();">
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
                    <h2 class="text-2xl text-white font-bold text-center">{{ $anime->title }}</h2>
                    <div class="mt-4 flex gap-4 justify-center items-center max-w-sm md:max-w-md lg:max-w-lg mx-auto">
                        <img src="{{ $anime->img_path }}" alt="{{ $anime->title }}" class="object-contain rounded-md mb-4" width="50%" height="auto">
                        <div class="flex flex-col justify-center text-md md:text-base lg:text-xl">
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Fecha de estreno: </span>{{ date('d M Y', strtotime($anime->release_date)) }}</p>
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Descripción: </span>{{ $anime->description }}</p>
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Valoración media: </span>{{ $anime->avg_score }}</p>
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Número de episodios: </span>{{ $anime->episodes }}</p>
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Estado de emisión: </span>{{ $anime->status }}</p>
                            <div class="flex justify-center mt-4">
                                <a href="{{ route('anime.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Volver a la lista
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @break
        @case(str_contains($header, "create"))
            <div class="container mx-auto px-4 py-8 mt-4">
                <div class="flex-row justify-center">
                    <form action="{{ route('anime.store') }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
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
                            <label for="status" class="block text-md font-medium text-gray-700 dark:text-gray-300">Estado de emisión</label>
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Proximamente" selected>Próximamente</option>
                                <option value="En emision">En emisión</option>
                                <option value="Finalizado">Finalizado</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="episodes" class="block text-md font-medium text-gray-700 dark:text-gray-300">Episodios</label>
                            <input type="number" name="episodes" id="episodes" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="avg_score" class="block text-md font-medium text-gray-700 dark:text-gray-300">Valoración media</label>
                            <input type="number" name="avg_score" id="avg_score" step="0.1" min="0" max="10" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded border">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            @break
        @case(str_contains($header, "edit"))
            <div class="container mx-auto px-4 py-8 mt-4">
                <div class="flex-row justify-center">
                    <form action="{{ route('anime.update', $anime->id) }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title" class="block text-md font-medium text-gray-700 dark:text-gray-300">Título</label>
                            <input type="text" name="title" id="title" value="{{ $anime->title }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="release_date" class="block text-md font-medium text-gray-700 dark:text-gray-300">Fecha de estreno</label>
                            <input type="date" name="release_date" id="release_date" value="{{ $anime->release_date }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-md font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $anime->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-md font-medium text-gray-700 dark:text-gray-300">Estado de emisión</label>
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Proximamente" {{ $anime->status == 'proximamente' ? 'selected' : '' }}>Próximamente</option>
                                <option value="En emision" {{ $anime->status == 'en emision' ? 'selected' : '' }}>En emisión</option>
                                <option value="Finalizado" {{ $anime->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="img_path" class="block text-md font-medium text-gray-700 dark:text-gray-300">URL Imagen</label>
                            <input type="url" name="img_path" id="img_path" value="{{ $anime->img_path }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="episodes" class="block text-md font-medium text-gray-700 dark:text-gray-300">Episodios</label>
                            <input type="number" name="episodes" id="episodes" value="{{ $anime->episodes }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="avg_score" class="block text-md font-medium text-gray-700 dark:text-gray-300">Valoración media</label>
                            <input type="number" name="avg_score" id="avg_score" step="0.1" min="0" max="10" value="{{ $anime->avg_score }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
        return confirm('¿Estás seguro de eliminar este anime?');
    }
</script>