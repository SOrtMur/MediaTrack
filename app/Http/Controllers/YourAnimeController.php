<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Anime;
use Illuminate\Support\Facades\Auth;


class YourAnimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $animes = $user->animes()->get();

        return view('your_animes', ['header' => 'index'], compact('animes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::find(Auth::user()->id);
        $yourAnimesIds = $user->animes()->pluck('anime_id')->toArray();
        $animes = Anime::all();

        return view('your_animes', ['header' => 'create'], compact('animes', 'yourAnimesIds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anime_id' => 'required',
            'watched_status' => 'required|string',
        ]);

        $user = User::find(Auth::user()->id);

        if ($user->animes()->where('anime_id', $request->anime_id)->exists()) {
            return redirect()->route('your_anime.index')->with('error', 'Anime ya añadido.');
        }

        $user->animes()->attach([
            $request->anime_id => [
                'watched_status' => $request->watched_status,
                'last_episode_watched' => $request->last_episode_watched ?? 0,
                'last_watched_date' => now(),
                'added_at' => now(),
            ]
        ]);

        return redirect()->route('your_anime.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //No se necesita implementar, ya que no se usa el del AnimeController.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find(Auth::user()->id);
        $anime = $user->animes()->where('anime_id', $id)->first();

        if (!$anime) {
            return redirect()->route('your_anime.index')->with('error', 'Anime no encontrado.');
        }

        return view('your_animes', ['header' => 'edit'], compact('anime'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'watched_status' => 'required|string',
            'last_episode_watched' => 'nullable|integer',
        ]);

        $user = User::find(Auth::user()->id);
        $anime = $user->animes()->where('anime_id', $id)->first();

        if (!$anime) {
            return redirect()->route('your_anime.index')->with('error', 'Anime no encontrado.');
        }

        $anime->pivot->watched_status = $request->watched_status;
        $anime->pivot->last_episode_watched = $request->last_episode_watched ?? 0;
        $anime->pivot->last_watched_date = now();
        $anime->pivot->save();

        return redirect()->route('your_anime.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find(Auth::user()->id);
        $anime = $user->animes()->where('anime_id', $id)->first();

        if (!$anime) {
            return redirect()->route('your_anime.index')->with('error', 'Anime no encontrado.');
        }

        $user->animes()->detach($id);

        return redirect()->route('your_anime.index');
    }
}
