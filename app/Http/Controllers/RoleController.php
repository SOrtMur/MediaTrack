<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        //return view('index', ['header' => "Roles"], compact('roles')); No implementado
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('create', ['header' => "Crear Rol"])); No implementado
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Role::create($request->all());
        //return redirect()->route('role.index'); No implementado
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);
        //return view('show', ['header' => "$role->name", 'role' => $role]); No implementado
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        //return view('edit', ['header' => "Editar Rol", 'role' => $role]); No implementado
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $role = Role::find($id);
        $role->update($request->all());
        //return redirect()->route('role.index'); No implementado
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::destroy($id);
        //return redirect()->route('role.index'); No implementado
    }
}
