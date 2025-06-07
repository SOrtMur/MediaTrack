<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class YourMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Auth::user()->movies()->get();
        return view('your_movies', ['header' => "index"], compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $movies = Movie::all();
        return view('your_movies', ['header' => "create", compact('movies')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data for id, title, duration, and release_date
        $request->validate([
            'title' => 'required|string|max:255',
            'view_status' => 'required|string',
            'watched_time' => 'required|integer|min:0',
        ]);

        // Create a new movie instance and save it
        Auth::user()->movies()->create([
            'title' => $request->title,
            'view_status' => $request->view_status ?? 'Pendiente',
            'watched_time' => $request->watched_time ?? 0,
            'added_at' => now(),
        ]);

        return redirect()->route('your_movie.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Auth::user()->movies()->find($id);
        
        if (!$movie) {
            return redirect()->route('your_movie.index')->with('error', 'Pelicula no encontrada.');
        }

        return view('your_movies', ['header' => "show", 'movie' => $movie]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $movie = Auth::user()->movies()->find($id);
        
        if (!$movie) {
            return redirect()->route('your_movie.index')->with('error', 'Pelicula no encontrada.');
        }

        return view('your_movies', ['header' => "edit", 'movie' => $movie]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'view_status' => 'required|string',
            'watched_time' => 'required|integer|min:0',
        ]);

        $movie = Auth::user()->movies()->find($id);
        
        if (!$movie) {
            return redirect()->route('your_movie.index')->with('error', 'Pelicula no encontrada.');
        }

        // Update the movie instance
        $movie->update([
            'title' => $request->title,
            'view_status' => $request->view_status,
            'watched_time' => $request->watched_time,
        ]);

        return redirect()->route('your_movie.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Auth::user()->movies()->find($id);
        
        if (!$movie) {
            return redirect()->route('your_movie.index')->with('error', 'Pelicula no encontrada.');
        }

        $movie->delete();
        
        return redirect()->route('your_movie.index');
    }
}
