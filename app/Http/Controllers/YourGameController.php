<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Game;

class YourGameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $games = $user->games()->get();
        return view('your_games', ['header' => "index"], compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::find(Auth::user()->id);
        
        $yourGamesIds = $user->games()->pluck('game_id')->toArray();

        $games = Game::all();
        return view('your_games', ['header' => "create"], compact('games', 'yourGamesIds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required',
            'played_status' => 'required|string',
        ]);

        $user = User::find(Auth::user()->id);

        if ($user->games()->where('game_id', $request->game_id)->exists()) {
            return redirect()->route('your_game.index')->with('error', 'Juego ya añadido.');
        }

        $user->games()->attach([
            $request->game_id => [
                'played_status' => $request->played_status,
                'played_time' => $request->played_time ?? 0,
                'added_at' => now(),
            ]
        ]);

        return redirect()->route('your_game.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //No se necesita, ya que se usa el método show de GameController
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find(Auth::user()->id);
        $game = $user->games()->find($id);

        if (!$game) {
            return redirect()->route('your_game.index')->with('error', 'Juego no encontrado.');
        }

        return view('your_games', ['header' => "edit", 'game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'played_status' => 'required|string',
            'played_time' => 'nullable|numeric',
        ]);

        $user = User::find(Auth::user()->id);
        $game = $user->games()->find($id);

        if (!$game) {
            return redirect()->route('your_game.index')->with('error', 'Juego no encontrado.');
        }

        $game->pivot->played_status = $request->played_status;
        $game->pivot->played_time = $request->played_time ?? 0;
        $game->pivot->last_played_at = now();
        $game->pivot->save();

        return redirect()->route('your_game.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find(Auth::user()->id);
        $game = $user->games()->find($id);

        if (!$game) {
            return redirect()->route('your_game.index')->with('error', 'Juego no encontrado.');
        }

        $user->games()->detach($id);

        return redirect()->route('your_game.index')->with('success', 'Juego eliminado correctamente.');
    }
}
