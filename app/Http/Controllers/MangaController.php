<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manga;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mangas = Manga::all();
        
        return view('mangas', ['header' => "index", 'mangas' => $mangas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mangas', ['header' => "create"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
            'status' => 'required|string',
            'chapters' => 'required|integer|min:1'
        ]);

        Manga::create([
            'id' => $request->id,
            'title' => $request->title,
            'description' => $request->description ?? null,
            'release_date' => $request->release_date,
            'status' => $request->status,
            'chapters' => $request->chapters,
            'avg_score' => $request->avg_score ?? null,
            'img_path' => $request->img_path ?? null,

        ]);

        return redirect()->route('manga.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $manga = Manga::find($id);
        
        return view('mangas', ['header' => 'show', 'manga' => $manga]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $manga = Manga::find($id);
        
        return view('mangas', ['header' => "edit", 'manga' => $manga]);
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
            'description' => $request->description ?? null,
            'release_date' => $request->release_date,
            'status' => $request->status,
            'chapters' => $request->chapters,
            'avg_score' => $request->avg_score ?? null,
            'img_path' => $request->img_path ?? null,
        ]);

        return redirect()->route('manga.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Manga::destroy($id);
        
        return redirect()->route('manga.index');
    }
}
