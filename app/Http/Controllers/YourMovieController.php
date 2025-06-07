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
        $user = User::find(Auth::user()->id);
        
        $yourMoviesIds = $user->movies()->pluck('movie_id')->toArray();

        $movies = Movie::all();
        return view('your_movies', ['header' => "create"], compact('movies','yourMoviesIds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data for id, title, duration, and release_date
        $request->validate([
            'movie_id' => 'required',
            'watched_status' => 'required|string',
        ]);

        $user = User::find(Auth::user()->id);

        if ($user->movies()->where('movie_id', $request->movie_id)->exists()) {
            return redirect()->route('your_movie.index')->with('error', 'Pelicula ya añadida.');
        }

        $user->movies()->attach([
            $request->movie_id =>[
            'watched_status' => $request->watched_status,
            'watched_time' => $request->watched_time ?? 0,
            'added_at' => now(),
        ]]);

        return redirect()->route('your_movie.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // El show queda implementado en el modelo Movie, no es necesario implementarlo aqui.
        // $movie = Auth::user()->movies()->find($id);
        
        // if (!$movie) {
        //     return redirect()->route('your_movie.index')->with('error', 'Pelicula no encontrada.');
        // }

        // return view('your_movies', ['header' => "show", 'movie' => $movie]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find(Auth::user()->id);
        $movie = $user->movies()->where('movie_id', $id)->first();
        
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
            'watched_status' => 'required|string',
            'watched_time' => 'required|integer|min:0',
        ]);

        $user = User::find(Auth::user()->id);
        $movie = $user->movies()->where('movie_id', $id)->first();   

        if (!$movie) {
            return redirect()->route('your_movie.index')->with('error', 'Pelicula no encontrada.');
        }

        // Update the movie instance
        $user->movies()->updateExistingPivot($id, [
            'watched_status' => $request->watched_status,
            'watched_time' => $request->watched_time,
        ]);

        return redirect()->route('your_movie.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find(Auth::user()->id);
        $movie = $user->movies()->where('movie_id', $id)->first();
        
        if (!$movie) {
            return redirect()->route('your_movie.index')->with('error', 'Pelicula no encontrada.');
        }

        $user->movies()->detach($id);
        
        return redirect()->route('your_movie.index');
    }
}
