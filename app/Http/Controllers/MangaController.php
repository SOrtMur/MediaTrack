<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mangas = Manga::all();
        
        // return view('mangas.index', ['header' => "Mangas"], compact('mangas')); No implementado
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('mangas.create', ['header' => "Crear Manga"]); No implementado
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:mangas',
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'status' => 'required|string',
            'chapters' => 'required|integer|min:1'
        ]);

        Manga::create([
            'id' => $request->id,
            'title' => $request->title,
            'release_date' => $request->release_date,
            'status' => $request->status,
            'chapters' => $request->chapters,
            'avg_score' => $request->avg_score ?? null,
            'img_path' => $request->img_path ?? null,

        ]);

        // return redirect()->route('mangas.index'); No implementado
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $manga = Manga::find($id);
        
        // return view('mangas.show', ['header' => $manga->title, 'manga' => $manga]); No implementado
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $manga = Manga::find($id);
        
        // return view('mangas.edit', ['header' => "Editar Manga", 'manga' => $manga]); No implementado
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'status' => 'required|string',
            'chapters' => 'required|integer|min:1'
        ]);

        $manga = Manga::find($id);
        $manga->update([
            'title' => $request->title,
            'release_date' => $request->release_date,
            'status' => $request->status,
            'chapters' => $request->chapters,
            'avg_score' => $request->avg_score ?? null,
            'img_path' => $request->img_path ?? null,
        ]);

        // return redirect()->route('mangas.index'); No implementado
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Manga::destroy($id);
        
        // return redirect()->route('mangas.index'); No implementado
    }
}
