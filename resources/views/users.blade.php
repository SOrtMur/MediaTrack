@extends('layouts.app')
@section('header')
    @switch($header)
        @case(str_contains($header, "index"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Lista de Usuarios</h1>
            @break
        @case(str_contains($header, "create"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Nuevo Usuario</h1>
            @break
        @case(str_contains($header, "edit"))
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Editar Usuario</h1>
            @break
    @endswitch
@endsection
@section('content')
    @switch($header)
        @case(str_contains($header, "index"))
            <div class="container relative mx-auto px-4 mt-4">
                <div class="flex justify-center mt-4">
                    <a href="{{ route('user.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded underline">
                        Añadir Usuario
                    </a>
                </div>
                <table class="mt-4 w-full bg-gray-100 dark:bg-gray-900 rounded-lg shadow border-collapse border border-gray-300 dark:border-gray-700">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b dark:text-white dark:border-gray-700">
                                <td class="px-4 py-2 text-center"> {{ $user->name }} </td>
                                <td class="px-4 py-2 text-center"> {{ $user->email }} </td>
                                <td class="px-4 py-2 text-center"> {{ $user->role()->where('user_id',$user->id)->first()->description }}</td>
                                <td class="px-4 py-2 flex gap-4 justify-center">
                                    <a href="{{ route('user.show', $user->id) }}" class="text-blue-500 pt-2">Ver</a>
                                    @unless (!Auth::user()->hasRole('admin'))
                                        <a href="{{ route('user.edit', $user->id) }}" class="text-white pt-2">Editar</a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirmDelete();" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 pt-2">Eliminar</button>
                                        </form>
                                    @endunless
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @break
        @case(str_contains($header, "show"))
            <div class="container mx-auto px-4 py-8 mt-4 ">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h2 class="text-2xl text-white font-bold text-center">Usuario: {{ $user->name }}</h2>
                    <div class="mt-4 flex gap-4 justify-center items-center max-w-sm md:max-w-md lg:max-w-lg mx-auto">
                        <div class="flex flex-col justify-center text-md md:text-base lg:text-xl">
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Nombre: </span>{{ $user->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Email: </span>{{ $user->email }}</p>
                            <p class="text-gray-600 dark:text-gray-400 mb-3"><span class="text-white font-semibold">Rol: </span>{{ $user->role()->where('user_id',$user->id)->first()->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @break
        @case(str_contains($header, "create"))
            <div class="container mx-auto px-4 py-8 mt-4">
                <div class="flex-row justify-center">
                    <form action="{{ route('user.store') }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow" onsubmit="return validatePasswords() && checkRole();">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-md font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-md font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-md font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="repass" class="block text-md font-medium text-gray-700 dark:text-gray-300">Repetir Contraseña</label>
                            <input type="password" name="repass" id="repass" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="role" class="block text-md font-medium text-gray-700 dark:text-gray-300">Rol</label>
                            <select name="role" id="role" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled selected>Seleccione un rol</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-center ">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded border">
                                Crear
                            </button>
                        </div>
                    </form>
                </div>
            @break
        @case(str_contains($header, "edit"))
            <div class="container mx-auto px-4 py-8 mt-4">
                <div class="flex-row justify-center">
                    <form action="{{ route('user.update', $user->id) }}" method="POST" class="basis-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-md font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-md font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="role" class="block text-md font-medium text-gray-700 dark:text-gray-300">Rol</label>
                            <select name="role" id="role" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($roles as $role)
                                    @if ($role->id == $user->role()->where("user_id",$user->id)->first()->id)
                                        <option value="{{$role->id}}" selected>{{$role->description}}</option>
                                    @else
                                        <option value="{{$role->id}}">{{$role->description}}</option>
                                    @endif
                                @endforeach
                            </select>
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
        return confirm('¿Estás seguro de que deseas eliminar este usuario?');
    }
    function validatePasswords() {
        const password = document.getElementById('password').value;
        const repass = document.getElementById('repass').value;
        if (password !== repass) {
            alert('Las contraseñas no coinciden');
            return false;
        }
        return true;
    }
    function checkRole(){
        const role = document.getElementById('role').value;
        if (role === '') {
            alert('Por favor, selecciona un rol');
            return false;
        }
        return true;
    }
</script>