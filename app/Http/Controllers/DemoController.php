<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DemoController extends Controller
{
    /**
     * Display a demo view.
     *
     * @return \Illuminate\View\View
     */
    public function demoIndex()
    {
        //Recuperar datos de TMDB con query 'ca', solo lee la primera página
        $resp = Http::get(config('services.tmdb.endpoint'). 'search/movie?query=ca&include_adult=false&language=en-US', [
                'api_key' => config('services.tmdb.api'),
                'query' => 'Jungla de Cristal',
                'language' => 'es-ES',
                'include_adult' => false,

            ])->collect();

        // Asignar los resultados a la variable $movies
        $movies = $resp['results'];



        return view('demo', compact('movies'));
    }
    /**
     * Display a demo view with a specific movie.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function demoShow(string $id){
        // Recuperar datos de TMDB para una película específica
        $resp = Http::get(config('services.tmdb.endpoint') . 'movie/' . $id, [
            'api_key' => config('services.tmdb.api'),
            'language' => 'es-ES',
        ])->collect();

        // Asignar los resultados a la variable $movie
        $movie = $resp;

        return view('demo_show', compact('movie'));
    }
}
