<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;


class APIController extends Controller
{
    /**
     * Handle the TMDB search request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function TMDBSearch(Request $request)
    {
        

        //Recuperar datos de TMDB con query
        $resp = Http::get(config('services.tmdb.endpoint'). 'search/movie', [
                'api_key' => config('services.tmdb.api'),
                'query' => $request->pelicula,
                'language' => 'es-ES',
                'include_adult' => false,
            ])->collect();

        // Asignar los resultados a la variable $movies
        $movies = $resp['results'];

        return view('tmdb', ['header' => 'index'], compact('movies'));
    }
    
    /**
     * Handle the TMDB show request for a specific movie.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function TMDBShow(string $id){
        // Recuperar datos de TMDB para una película específica
        $resp = Http::get(config('services.tmdb.endpoint') . 'movie/' . $id, [
            'api_key' => config('services.tmdb.api'),
            'language' => 'es-ES',
        ])->collect();

        // Asignar los resultados a la variable $movie
        $movie = $resp;

        return view('tmdb', ['header' => 'show'] , compact('movie'));
    }
}
