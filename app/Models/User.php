<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Role;
use App\Models\Movie;
use App\Models\Manga;
use App\Models\Game;
use App\Models\Anime;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function role(): BelongsToMany{
        return $this->belongsToMany(Role::class, 'roles_users');
    }

    public function movies(){
        return $this->belongsToMany(Movie::class, 'movies_users')->withPivot('watched_status', 'watched_time', 'added_at');
    }

    public function mangas(){
        return $this->belongsToMany(Manga::class, 'mangas_users')->withPivot('read_status', 'last_chapter_read', 'added_at', 'last_read_at');
    }

    public function games(){
        return $this->belongsToMany(Game::class, 'games_users')->withPivot('played_status', 'played_time', 'added_at', 'last_played_at');
    }

    public function animes(){
        return $this->belongsToMany(Anime::class, 'animes_users')->withPivot('watched_status', 'last_episode_watched', 'last_watched_date', 'added_at');
    }

    // Metodo para el middleware, comprobando si el usuario tiene un rol especifico.
    public function hasRole($role){
        $rolAuth = Auth::user()->role()->first()->name;
        if(str_contains($role, $rolAuth)){
            return true;
        }
        return false;
    }
}
