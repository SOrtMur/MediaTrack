<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anime;


class AnimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animes = Anime::all();
        return view('animes', ['header' => "index"], compact('animes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('animes', ['header' => "create"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'episodes' => 'required|integer|min:1',
            'status' => 'required|string'
        ]);

        Anime::create([
            'title' => $request->title,
            'description' => $request->description ?? null,
            'release_date' => $request->release_date,
            'episodes' => $request->episodes,
            'status' => $request->status,
            'avg_score' => $request->avg_score ?? null,
            'img_path' => $request->img_path ?? null
        ]);

        return redirect()->route('anime.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anime = Anime::find($id);
        return view('animes', ['header' => 'show', 'anime' => $anime]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->hasRole('user|admin')) {
            return redirect()->route('movie.index');
        }
        
        $anime = Anime::find($id);
        return view('animes', ['header' => "edit", 'anime' => $anime]);
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
            'episodes' => 'required|integer|min:1',
            'status' => 'required|string'
        ]);

        $anime = Anime::find($id);
        $anime->update([
            'title' => $request->title,
            'description' => $request->description ?? null,
            'release_date' => $request->release_date,
            'episodes' => $request->episodes,
            'status' => $request->status ?? 'Proximamente',
            'avg_score' => $request->avg_score ?? null,
            'img_path' => $request->img_path ?? null
        ]);
        return redirect()->route('anime.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->hasRole('user|admin')) {
            return redirect()->route('movie.index');
        }
        
        Anime::destroy($id);
        return redirect()->route('anime.index');
    }
}
