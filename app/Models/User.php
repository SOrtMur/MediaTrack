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
        return $this->belongsToMany(Movie::class, 'movies_users');
    }

    public function mangas(){
        return $this->belongsToMany(Manga::class, 'mangas_users');
    }

    public function games(){
        return $this->belongsToMany(Game::class, 'games_users');
    }

    public function animes(){
        return $this->belongsToMany(Anime::class, 'animes_users');
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
