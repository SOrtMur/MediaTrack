<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $juegos = Game::all();
        //return view('games.index', ['header' => "Juegos"], compact('juegos')); No implementado
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('games.create', ['header' => "Crear Juego"]); No implementado
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id' => 'required|unique:games',
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'platforms' => 'required|array',
        ]);

        // Create a new game instance and save it
        Game::create([
            'id' => $request->id,
            'title' => $request->title,
            'release_date' => $request->release_date,
            'platforms' => json_encode($request->platforms),
            'avg_rate' => $request->avg_rate ?? null,
        ]);

        //return redirect()->route('games.index'); No implementado
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::find($id);
        
        //return view('games.show', ['header' => $game->title, 'game' => $game]); No implementado
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $game = Game::find($id);
        //return view('games.edit', ['header' => "Editar Juego", 'game' => $game]); No implementado
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'platforms' => 'required|array',
        ]);

        $game = Game::find($id);
        $game->update([
            'title' => $request->title,
            'release_date' => $request->release_date,
            'platforms' => json_encode($request->platforms),
            'avg_rate' => $request->avg_rate ?? null,
        ]);

        //return redirect()->route('games.index'); No implementado
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Game::destroy($id);
        //return redirect()->route('games.index'); No implementado
    }
}
