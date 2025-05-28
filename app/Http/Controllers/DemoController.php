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
    public function demo()
    {
        $tmdb_id = 436270; // Example TMDB ID

        $movie = Http::asJson()
            ->get(config('services.tmdb.endpoint').'movie/'.$tmdb_id.'?api_key='.config('services.tmdb.key'));
        
    
        return view('demo', compact('movie'));
    }
}
