<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function role(): BelongsToMany{
        return $this->belongsToMany(Role::class, 'roles_users');
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
