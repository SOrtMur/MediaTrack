<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();
        return view('games', ['header' => "index"], compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('games', ['header' => "create"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
        ]);

        Game::create([
            'title' => $request->title,
            'description' => $request->description ?? null,
            'release_date' => $request->release_date,
            'avg_score' => $request->avg_score ?? null,
            'img_path' => $request->img_path ?? null,
        ]);

        return redirect()->route('game.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::find($id);
        
        return view('games', ['header' => 'show', 'game' => $game]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasRole('user|admin')) {
            return redirect()->route('movie.index');
        }

        $game = Game::find($id);
        return view('games', ['header' => "edit", 'game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->hasRole('user|admin')) {
            return redirect()->route('movie.index');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
        ]);

        $game = Game::find($id);
        $game->update([
            'title' => $request->title,
            'description' => $request->description ?? null,
            'release_date' => $request->release_date,
            'avg_score' => $request->avg_score ?? null,
            'img_path' => $request->img_path ?? null,
        ]);

        return redirect()->route('game.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->hasRole('user|admin')) {
            return redirect()->route('movie.index');
        }
        
        Game::destroy($id);
        return redirect()->route('game.index');
    }
}
