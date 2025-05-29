<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animes = Anime::all();
        //return view('animes.index', ['header' => "Animes"], compact('animes')); No implementado
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('animes.create', ['header' => "Crear Anime"]); No implementado
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:animes',
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'episodes' => 'required|integer|min:1',
            'status' => 'required|string'
        ]);

        Anime::create([
            'id' => $request->id,
            'title' => $request->title,
            'release_date' => $request->release_date,
            'episodes' => $request->episodes,
            'status' => $request->status,
            'avg_score' => $request->avg_score ?? null,
            'img_path' => $request->img_path ?? null
        ]);

        //return redirect()->route('animes.index'); No implementado
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anime = Anime::find($id);
        //return view('animes.show', ['header' => $anime->title, 'anime' => $anime]); No implementado
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $anime = Anime::find($id);
        //return view('animes.edit', ['header' => "Editar Anime", 'anime' => $anime]); No implementado
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'episodes' => 'required|integer|min:1',
            'status' => 'required|string'
        ]);

        $anime = Anime::find($id);
        $anime->update([
            'title' => $request->title,
            'release_date' => $request->release_date,
            'episodes' => $request->episodes,
            'status' => $request->status,
            'avg_score' => $request->avg_score ?? null,
            'img_path' => $request->img_path ?? null
        ]);
        //return redirect()->route('animes.index'); No implementado
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Anime::destroy($id);
        //return redirect()->route('animes.index'); No implementado
    }
}
