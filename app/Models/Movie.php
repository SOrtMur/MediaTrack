<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;


class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'duration',
        'release_date',
        'avg_rate',
        'img_path',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'movies_users');
    }
}
