<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manga;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class YourMangaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $mangas = $user->mangas()->get();

        return view('your_mangas', ['header' => "index"], compact('mangas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $yourMangasIds = $user->mangas()->pluck('manga_id')->toArray();

        $mangas = Manga::all();
        return view('your_mangas', ['header' => "create"], compact('mangas', 'yourMangasIds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'manga_id' => 'required',
            'read_status' => 'required|string',
        ]);
        $user = User::find(Auth::user()->id);

        if ($user->mangas()->where('manga_id', $request->manga_id)->exists()) {
            return redirect()->route('your_manga.index')->with('error', 'Manga ya añadido.');
        }

        // Add the manga to the user's collection
        $user->mangas()->attach([
            $request->manga_id => [
                'read_status' => $request->read_status,
                'last_chapter_read' => $request->last_chapter_read ?? 0,
                'added_at' => now(),
                'last_read_at' => ($request->read_status !== 'Pendiente') ? now() : null,
        ]]);

        return redirect()->route('your_manga.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //No se necesita, ya que se usa el show de MangaController
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $manga = $user->mangas()->where('manga_id', $id)->first();

        if (!$manga) {
            return redirect()->route('your_manga.index')->with('error', 'Manga no encontrado.');
        }

        return view('your_mangas', ['header' => "edit"], compact('manga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'read_status' => 'required|string',
            'last_chapter_read' => 'nullable|integer',
        ]);

        $user = Auth::user();
        $manga = $user->mangas()->where('manga_id', $id)->first();

        if (!$manga) {
            return redirect()->route('your_manga.index')->with('error', 'Manga no encontrado.');
        }

        // Update the manga in the user's collection
        $user->mangas()->updateExistingPivot($id, [
            'read_status' => $request->read_status,
            'last_chapter_read' => $request->last_chapter_read ?? 0,
            'last_read_at' => ($request->read_status !== 'Pendiente') ? now() : null,
        ]);

        return redirect()->route('your_manga.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $manga = $user->mangas()->where('manga_id', $id)->first();

        if (!$manga) {
            return redirect()->route('your_manga.index')->with('error', 'Manga no encontrado.');
        }

        // Detach the manga from the user's collection
        $user->mangas()->detach($id);

        return redirect()->route('your_manga.index');
    }
}
