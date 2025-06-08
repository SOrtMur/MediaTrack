@extends('layouts.app')
@section('header')
    <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Buscador de Películas </h1>
    <p class="text-center text-gray-600 dark:text-gray-400 mt-2">Explora y encuentra información sobre tus películas</p>
@endsection
@section('content')
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <form method="GET" action="{{ route('') }}" class="flex items-center space-x-4">
                <input type="text" name="query" placeholder="Buscar películas" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" required>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Buscar</button>
            </form>
        </div> 
    </div>
@endsection
