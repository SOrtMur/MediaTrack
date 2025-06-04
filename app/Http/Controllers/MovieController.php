<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::all();
        return view('movies', ['header' => "index"], compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('movies', ['header' => "create"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data de id, title, duration and release_date
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'release_date' => 'required|date',
        ]);
        // Create a new movie instance and save it
        Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'release_date' => $request->release_date,
            'avg_rate' => $request->avg_rate ?? null,
            'img_path' => $request->img_path ?? "https://4ddig.tenorshare.com/images/photo-recovery/images-not-found.jpg",
        ]);

        return redirect()->route('movie.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::find($id);
        
        return view('movies', ['header' => "show",'movie' => $movie]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $movie = Movie::find($id);
        
        //return view('movies.edit', ['header' => "Editar Película", 'movie' => $movie]); No implementado
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'release_date' => 'required|date',
            'avg_rate' => 'nullable|numeric|min:0|max:10',
        ]);

        $movie = Movie::find($id);

        $movie->update([
            'title' => $request->title,
            'duration' => $request->duration,
            'release_date' => $request->release_date,
            'avg_rate' => $request->avg_rate ?? $movie->avg_rate,
            'img_path' => $request->img_path ?? $movie->img_path,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::destroy($id);
        
        return redirect()->route('movie.index');
    }
}
